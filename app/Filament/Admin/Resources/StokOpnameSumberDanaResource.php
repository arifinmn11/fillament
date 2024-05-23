<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\StokOpnameSumberDanaResource\Pages;
use App\Filament\Admin\Resources\StokOpnameSumberDanaResource\RelationManagers;
use App\Models\Cabang;
use App\Models\StokOpnameSumberDana;
use App\Models\SumberDana;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StokOpnameSumberDanaResource extends Resource
{
    protected static ?string $model = StokOpnameSumberDana::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Pengisian Saldo';

    protected static ?string $pluralModelLabel = 'Pengisian Saldo';

    protected static ?string $navigationLabel = 'Pengisian Saldo';

    protected static ?string $navigationGroup = 'Keuangan';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('sumber_dana_id')
                    ->label('Sumber Dana')
                    ->relationship('sumber_dana', 'nama')
                    ->required(),
                TextInput::make('harga_beli')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()
                    ->required(),
                TextInput::make('saldo')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()
                    ->required(),
                DateTimePicker::make('tgl_transaksi')
                    ->label('Tanggal Transaksi')
                    ->default(now())
                    ->required(),
                Textarea::make('keterangan')->label('Keterangan'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sumber_dana.nama')
                    ->label('Sumber Dana')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('harga_beli')
                    ->label('Harga Beli')
                    ->sortable(),
                TextColumn::make('saldo')
                    ->label('Saldo')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('user_catat.name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('keterangan')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('tgl_transaksi')
                    ->sortable()
                    ->dateTime()
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStokOpnameSumberDanas::route('/'),
            'create' => Pages\CreateStokOpnameSumberDana::route('/create'),
            'edit' => Pages\EditStokOpnameSumberDana::route('/{record}/edit'),
        ];
    }
}
