<?php

namespace App\Filament\Admin\Resources\InventoryBarangResource\Pages;

use App\Filament\Admin\Resources\InventoryBarangResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInventoryBarang extends EditRecord
{
    protected static string $resource = InventoryBarangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
