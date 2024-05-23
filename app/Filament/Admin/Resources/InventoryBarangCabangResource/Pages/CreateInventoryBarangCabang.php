<?php

namespace App\Filament\Admin\Resources\InventoryBarangCabangResource\Pages;

use App\Filament\Admin\Resources\InventoryBarangCabangResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Filament\Notifications\Notification;

class CreateInventoryBarangCabang extends CreateRecord
{
    protected static string $resource = InventoryBarangCabangResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $validator = Validator::make($data, [
            'cabang_id' => [
                'required',
                Rule::unique('inventory_barang_cabang')->where(function ($query) use ($data) {
                    return $query->where('inventory_barang_id', $data['inventory_barang_id'])->where('cabang_id', $data['cabang_id']);
                }),
            ],
        ]);

        if ($validator->fails()) {

            Notification::make()
                ->title('Validation Error')
                ->body('Failed! Barang sudah ada di cabang ini!')
                ->danger()
                ->send();

            throw ValidationException::withMessages([
                'cabang_id' => ['Barang sudah ada di cabang ini!'],
                'inventory_barang_id' => ['Barang sudah ada di cabang ini!']
            ]);
        }

        return $data;
    }
}
