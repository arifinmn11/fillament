<?php

namespace App\Filament\Admin\Resources\StokOpnameInventoryBarangCabangResource\Pages;

use App\Filament\Admin\Resources\StokOpnameInventoryBarangCabangResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStokOpnameInventoryBarangCabangs extends ListRecords
{
    protected static string $resource = StokOpnameInventoryBarangCabangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
