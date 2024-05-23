<?php

namespace App\Filament\Admin\Resources\InventoryBarangCabangResource\Pages;

use App\Filament\Admin\Resources\InventoryBarangCabangResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInventoryBarangCabangs extends ListRecords
{
    protected static string $resource = InventoryBarangCabangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
