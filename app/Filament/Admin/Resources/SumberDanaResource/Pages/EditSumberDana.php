<?php

namespace App\Filament\Admin\Resources\SumberDanaResource\Pages;

use App\Filament\Admin\Resources\SumberDanaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSumberDana extends EditRecord
{
    protected static string $resource = SumberDanaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
