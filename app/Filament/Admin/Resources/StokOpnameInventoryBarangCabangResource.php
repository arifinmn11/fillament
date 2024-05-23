<?php

namespace App\Filament\Admin\Resources;

use App\Exports\StokOpnameInventoryBarangCabangExport;
use App\Filament\Admin\Resources\StokOpnameInventoryBarangCabangResource\Pages;
use App\Filament\Admin\Resources\StokOpnameInventoryBarangCabangResource\RelationManagers;
use App\Models\Cabang;
use App\Models\InventoryBarangCabang;
use App\Models\StokOpnameInventoryBarangCabang;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
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
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class StokOpnameInventoryBarangCabangResource extends Resource
{
    protected static ?string $model = StokOpnameInventoryBarangCabang::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Stok Opname Inventory Barang Cabang';

    protected static ?string $pluralModelLabel = 'Stok Opname Inventory Barang Cabang';

    protected static ?string $navigationLabel = 'Stok Opname Barang';

    protected static ?string $navigationGroup = 'Stok Opname';

    protected static ?int $navigationSort = 3;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('inv_barang_cabang_id')
                    ->label('Inventory Barang Cabang')
                    ->options(function (callable $get) {
                        return InventoryBarangCabang::join('inventory_barang', 'inventory_barang_cabang.inventory_barang_id', '=', 'inventory_barang.id')
                            ->join('cabang', 'inventory_barang_cabang.cabang_id', '=', 'cabang.id')
                            ->selectRaw('CONCAT("CABANG : ", cabang.nama, " - NAMA : ", inventory_barang.nama, " - STOK : ", inventory_barang_cabang.stok) as nama, inventory_barang_cabang.id')
                            ->pluck('nama', 'id');
                    })
                    ->optionsLimit(100)
                    ->searchable()
                    ->required(),
                TextInput::make('harga_beli')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()
                    ->reactive()
                    ->afterStateUpdated(fn ($state, callable $set, callable $get) => $set('total_harga', $state * $get('stok') ?? 0))
                    ->required(),
                TextInput::make('stok')
                    ->numeric()
                    ->reactive()
                    ->default(1)
                    ->afterStateUpdated(fn ($state, callable $set, callable $get) => $set('total_harga', $state * $get('harga_beli') ?? 0))
                    ->required(),
                TextInput::make('total_harga')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()
                    ->disabled()
                    ->readonly()
                    ->required(),
                DateTimePicker::make('tgl_transaksi')
                    ->label('Tanggal Transaksi')
                    ->default(now())
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('inventory_barang_cabang.cabang.nama')
                    ->label('Cabang')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('inventory_barang_cabang.inventory_barang.nama')
                    ->label('Inventory Barang')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('harga_beli')
                    ->label('Harga Beli')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('stok')
                    ->label('Stok')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('total_harga')
                    ->label('Total Harga')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('user_catat.name')
                    ->label('User')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('tgl_transaksi')
                    ->label('Tanggal Transaksi')
                    ->dateTime()
                    ->sortable()
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
            ])
            ->headerActions([
                ExportAction::make()->exports([
                    ExcelExport::make()->fromTable()
                ])
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
            'index' => Pages\ListStokOpnameInventoryBarangCabangs::route('/'),
            'create' => Pages\CreateStokOpnameInventoryBarangCabang::route('/create'),
            'edit' => Pages\EditStokOpnameInventoryBarangCabang::route('/{record}/edit'),
        ];
    }
}
