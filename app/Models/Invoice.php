<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\InvoiceStatus;


class Invoice extends Model
{

    protected $fillable = [
        'customer_id',
        'date',
        'amount',
        'status'
    ];

    protected $casts = [
        'status' => InvoiceStatus::class,
    ];

    public function customer()
    {
    return $this->belongsTo(Customer::class);
    }

}
