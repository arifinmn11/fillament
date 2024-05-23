<?php

namespace App\Filament\Admin\Resources\InventoryBarangCabangResource\Pages;

use App\Filament\Admin\Resources\InventoryBarangCabangResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class EditInventoryBarangCabang extends EditRecord
{
    protected static string $resource = InventoryBarangCabangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $validator = Validator::make($data, [
            'cabang_id' => [
                'required',
                Rule::unique('inventory_barang_cabang')->where(function ($query) use ($data) {
                    return $query->where('inventory_barang_id', $data['inventory_barang_id'])
                        ->where('cabang_id', $data['cabang_id'])
                        ->where('id', '!=', $this->data['id']);
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
