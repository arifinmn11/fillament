<?php

namespace App\Filament\Admin\Resources\StokOpnameSumberDanaResource\Pages;

use App\Filament\Admin\Resources\StokOpnameSumberDanaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStokOpnameSumberDanas extends ListRecords
{
    protected static string $resource = StokOpnameSumberDanaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
