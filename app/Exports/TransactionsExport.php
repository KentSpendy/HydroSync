<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransactionsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Transaction::select('customer_name', 'amount', 'payment_status', 'delivery_group', 'created_at')->get();
    }

    public function headings(): array
    {
        return [
            'Customer Name',
            'Amount',
            'Status',
            'Delivery Group',
            'Date',
        ];
    }
}

