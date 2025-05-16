<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $customerCount = DB::table('customers')->count();
        $invoiceCount = DB::table('invoices')->count();

        return view('dashboard', compact('customerCount', 'invoiceCount'));
    }
}
