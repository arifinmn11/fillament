<?php

namespace App\Filament\Admin\Resources\StokOpnameSumberDanaResource\Pages;

use App\Filament\Admin\Resources\StokOpnameSumberDanaResource;
use App\Models\SumberDana;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CreateStokOpnameSumberDana extends CreateRecord
{
    protected static string $resource = StokOpnameSumberDanaResource::class;


    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_catat_id'] = Auth::id();


        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        return DB::transaction(function () use ($data) {
            // Create the StokOpnameSumberDana record
            $stokOpname = static::getModel()::create($data);

            // Update the saldo in the SumberDana table
            $sumberDana = SumberDana::find($data['sumber_dana_id']);
            if ($sumberDana) {
                $sumberDana->update([
                    'saldo' => $sumberDana->saldo + $data['saldo']
                ]);
            }

            return $stokOpname;
        });
    }
}
