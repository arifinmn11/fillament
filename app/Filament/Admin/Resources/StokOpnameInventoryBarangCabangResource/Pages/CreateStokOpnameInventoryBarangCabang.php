<?php

namespace App\Filament\Admin\Resources\StokOpnameInventoryBarangCabangResource\Pages;

use App\Filament\Admin\Resources\StokOpnameInventoryBarangCabangResource;
use App\Models\StokOpnameInventoryBarangCabang;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class CreateStokOpnameInventoryBarangCabang extends CreateRecord
{
    protected static string $resource = StokOpnameInventoryBarangCabangResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_catat_id'] = Auth::id();

        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        return DB::transaction(function () use ($data) {
            // Create the StokOpnameInventoryBarangCabang record
            $stokOpname = static::getModel()::create($data);

            // Update the stok in the InventoryBarangCabang table
            $inventoryBarangCabang = StokOpnameInventoryBarangCabang::find($data['inv_barang_cabang_id']);
            if ($inventoryBarangCabang) {
                $inventoryBarangCabang->update([
                    'stok' => $inventoryBarangCabang->stok + $data['stok']
                ]);
            }

            return $stokOpname;
        });
    }
}
