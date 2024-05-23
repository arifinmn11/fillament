<?php

namespace App\Filament\Admin\Resources\InventoryBarangResource\Pages;

use App\Filament\Admin\Resources\InventoryBarangResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInventoryBarangs extends ListRecords
{
    protected static string $resource = InventoryBarangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
