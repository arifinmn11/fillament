<?php

namespace App\Filament\Admin\Resources\KategoriPembayaranResource\Pages;

use App\Filament\Admin\Resources\KategoriPembayaranResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKategoriPembayarans extends ListRecords
{
    protected static string $resource = KategoriPembayaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
