<?php

namespace App\Filament\Exports;

use App\Models\StokOpnameInventoryBarangCabang;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class StokOpnameInventoryBarangCabangExporter extends Exporter
{
    protected static ?string $model = StokOpnameInventoryBarangCabang::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('inv_barang_cabang_id'),
            ExportColumn::make('harga_beli'),
            ExportColumn::make('stok'),
            ExportColumn::make('total_harga'),
            ExportColumn::make('tgl_transaksi'),
            ExportColumn::make('user_catat_id'),
            ExportColumn::make('keterangan'),
            ExportColumn::make('deleted_at'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your stok opname inventory barang cabang export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
