<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Invoice;
use Illuminate\Support\Facades\Validator;
use App\Enums\InvoiceStatus;
use Illuminate\Validation\Rules\Enum;

class UnifiedController extends Controller
{
    // GET /api/list
    public function list()
    {
        return response()->json([
            'customers' => Customer::latest()->get(),
            'invoices' => Invoice::with('customer')->latest()->get(),
            'statuses' => collect(InvoiceStatus::cases())
                        ->map(fn($case) => ['label' => $case->name, 'value' => $case->value])
        ]);
    }

    // POST /api/create
    public function create(Request $request)
    {
        $type = $request->input('type');
        $data = $request->input('data', []); // Provide empty array as default

        if ($type === 'customer') {
            $validator = Validator::make($data, [
                'name' => 'required|string|max:255',
                'phone' => 'nullable|string|max:20',
                'email' => 'nullable|email|max:255',
                'address' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $customer = Customer::create($validator->validated());
            return response()->json([
                'message' => 'Customer created', 
                'customer' => $customer
            ], 201);

        } elseif ($type === 'invoice') {
            $validator = Validator::make($data, [
                'customer_id' => 'required|exists:customers,id',
                'date' => 'required|date',
                'amount' => 'required|numeric|min:0',
                'status' => ['required', new Enum(InvoiceStatus::class)],
            ]);

            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            $invoice = Invoice::create($validator->validated());
            return response()->json([
                'message' => 'Invoice created', 
                'invoice' => $invoice
            ], 201);

        } else {
            return response()->json([
                'error' => 'Invalid type. Must be customer or invoice.'
            ], 400);
        }
    }

    public function update(Request $request)
{
    $type = $request->input('type');
    $id = $request->input('id');
    $data = $request->input('data', []);

    if ($type === 'customer') {
        $customer = Customer::find($id);
        if (!$customer) {
            return response()->json(['error' => 'Customer not found'], 404);
        }

        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $customer->update($validator->validated());
        return response()->json(['message' => 'Customer updated', 'customer' => $customer]);

    } elseif ($type === 'invoice') {
        $invoice = Invoice::find($id);
        if (!$invoice) {
            return response()->json(['error' => 'Invoice not found'], 404);
        }

        $validator = Validator::make($data, [
            'customer_id' => 'required|exists:customers,id',
            'date' => 'required|date',
            'amount' => 'required|numeric|min:0',
            'status' => ['required', new Enum(InvoiceStatus::class)],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $invoice->update($validator->validated());
        return response()->json(['message' => 'Invoice updated', 'invoice' => $invoice]);
    }

    return response()->json(['error' => 'Invalid type. Must be customer or invoice.'], 400);
}

}