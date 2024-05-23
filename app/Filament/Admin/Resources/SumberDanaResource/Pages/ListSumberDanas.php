<?php

namespace App\Filament\Admin\Resources\SumberDanaResource\Pages;

use App\Filament\Admin\Resources\SumberDanaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSumberDanas extends ListRecords
{
    protected static string $resource = SumberDanaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getTableRecordsPerPageSelectOptions(): ?array
    {
        return [5, 10, 25, 50, 100];
    }
}
