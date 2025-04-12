<?php

namespace App\Exports;

use App\Models\Commission;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CommissionsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Commission::with('consultant')->get()->map(function($commission) {
            return [
                'ID' => $commission->id,
                'Danışman' => $commission->consultant->name,
                'Fiyat' => $commission->price,
                'Yüzde' => $commission->percentage,
                'Komisyon Tutarı' => $commission->commission_amount,
                'Oluşturulma Tarihi' => $commission->created_at->format('d/m/Y H:i')
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Danışman',
            'Fiyat',
            'Yüzde',
            'Komisyon Tutarı',
            'Oluşturulma Tarihi'
        ];
    }
} 