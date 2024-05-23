<?php

namespace App\Filament\Admin\Resources\StokOpnameSumberDanaResource\Pages;

use App\Filament\Admin\Resources\StokOpnameSumberDanaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStokOpnameSumberDana extends EditRecord
{
    protected static string $resource = StokOpnameSumberDanaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
