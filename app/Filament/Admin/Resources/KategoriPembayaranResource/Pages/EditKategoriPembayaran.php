<?php

namespace App\Filament\Admin\Resources\KategoriPembayaranResource\Pages;

use App\Filament\Admin\Resources\KategoriPembayaranResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditKategoriPembayaran extends EditRecord
{
    protected static string $resource = KategoriPembayaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeUpdate(array $data): array
    {


        // Removed dd($data) to ensure the function completes and returns data.
        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        if (!$data['is_harga_flexible']) {
            $data['laba'] = $data['harga_jual'] - $data['harga_beli'];
        }

        if ($data['is_harga_flexible']) {
            $data['harga_beli'] = 0;
            $data['harga_jual'] = 0;
        }

        $record->update($data);

        return $record;
    }
}
