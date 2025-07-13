<?php

namespace App\Exports;

use App\Models\Expense;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExpensesExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Expense::select('description', 'category', 'amount', 'date', 'created_at')->get();
    }

    public function headings(): array
    {
        return [
            'Description',
            'Category',
            'Amount',
            'Expense Date',
            'Created At',
        ];
    }
}

