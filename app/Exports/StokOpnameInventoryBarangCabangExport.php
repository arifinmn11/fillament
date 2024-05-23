<?php

namespace App\Exports;

use App\Models\StokOpnameInventoryBarangCabang;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;

class StokOpnameInventoryBarangCabangExport implements FromQuery, WithHeadings
{
    use Exportable;

    public function query()
    {
        return StokOpnameInventoryBarangCabang::query();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Cabang',
            'Inventory Barang Cabang',
            'Stok Opname',
            'Stok',
            'Created At',
            'Updated At',
        ];
    }
}
