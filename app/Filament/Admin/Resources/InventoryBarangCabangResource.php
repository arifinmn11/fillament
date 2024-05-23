<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\InventoryBarangCabangResource\Pages;
use App\Filament\Admin\Resources\InventoryBarangCabangResource\RelationManagers;
use App\Models\InventoryBarangCabang;
use Filament\Forms;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class InventoryBarangCabangResource extends Resource
{
    protected static ?string $model = InventoryBarangCabang::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Inventaris Barang Cabang';

    protected static ?string $pluralModelLabel = 'Inventaris Barang Cabang';

    protected static ?string $navigationLabel = 'Inventaris Barang Cabang';

    protected static ?string $navigationGroup = 'Master Data';

    protected static ?int $navigationSort = 3;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('inventory_barang_id')
                    ->label('Inventaris Barang')
                    ->relationship('inventory_barang', 'nama')
                    ->required(),
                Select::make('cabang_id')
                    ->label('Cabang')
                    ->relationship('cabang', 'nama')
                    ->required(),

                Radio::make('is_laba_fleksibel')
                    ->label('Laba Fleksibel')
                    ->boolean()
                    ->default(false)
                    ->reactive()
                    ->required()
                    ->columnSpanFull()
                    ->afterStateUpdated(fn ($state, callable $set) => ([
                        $set('harga_beli', $state ? null : ''),
                        $set('harga_jual', $state ? null : ''),
                    ])),
                TextInput::make('stok')
                    ->label('Stok')
                    ->numeric()
                    ->default(0)
                    ->required(),
                TextInput::make('harga_beli')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()
                    ->required()
                    ->hidden(fn ($get) => $get('is_laba_fleksibel')),
                TextInput::make('harga_jual')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()
                    ->required()
                    ->hidden(fn ($get) => $get('is_laba_fleksibel')),
                TextInput::make('laba')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('inventory_barang.nama')->sortable()->searchable(),
                TextColumn::make('cabang.nama')->sortable()->searchable(),
                TextColumn::make('is_laba_fleksibel')->sortable()->searchable(),
                TextColumn::make('stok')->sortable(),
                TextColumn::make('harga_beli')->sortable(),
                TextColumn::make('harga_jual')->sortable(),
                TextColumn::make('laba')->sortable(),
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
            'index' => Pages\ListInventoryBarangCabangs::route('/'),
            'create' => Pages\CreateInventoryBarangCabang::route('/create'),
            'edit' => Pages\EditInventoryBarangCabang::route('/{record}/edit'),
        ];
    }
}
