<?php

namespace App\Filament\Admin\Resources\InventoryBarangCabangResource\Pages;

use App\Filament\Admin\Resources\InventoryBarangCabangResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInventoryBarangCabang extends EditRecord
{
    protected static string $resource = InventoryBarangCabangResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
