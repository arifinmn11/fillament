<?php

namespace App\Filament\Admin\Resources\KategoriPembayaranResource\Pages;

use App\Filament\Admin\Resources\KategoriPembayaranResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateKategoriPembayaran extends CreateRecord
{
    protected static string $resource = KategoriPembayaranResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (!$data['is_harga_flexible']) {
            $data['laba'] = $data['harga_jual'] - $data['harga_beli'];
        }

        if ($data['is_harga_flexible'] ) {
            $data['harga_beli'] = 0;
            $data['harga_jual'] = 0;
        }

        return $data;
    }


}
