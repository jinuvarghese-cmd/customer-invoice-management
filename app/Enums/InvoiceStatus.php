<?php
namespace App\Enums;

enum InvoiceStatus: string
{
    case Unpaid = 'Unpaid';
    case Paid = 'Paid';
    case Cancelled = 'Cancelled';
}
