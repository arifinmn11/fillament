<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TransaksiResource\Pages;
use App\Filament\Admin\Resources\TransaksiResource\RelationManagers;
use App\Models\Cabang;
use App\Models\InventoryBarangCabang;
use App\Models\SumberDana;
use App\Models\Transaksi;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TransaksiResource extends Resource
{
    protected static ?string $model = Transaksi::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $pluralModelLabel = 'Transaksi';

    protected static ?string $navigationLabel = 'Transaksi';

    protected static ?string $navigationGroup = 'Transaksi';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        $jenisTransaksi = null;
        return $form
            ->schema([
                DateTimePicker::make('tgl_transaksi')
                    ->label('Tanggal Transaksi')
                    ->default(now())
                    ->required()
                    ->reactive(),
                Select::make('cabang_id')->options(Cabang::all()->pluck('nama', 'id'))->default(auth()->user()->cabang_id)->disabled()->required(),
                Select::make('is_sumber_dana')
                    ->label('Jenis Transaksi')
                    ->options([
                        1 => 'Tagihan/Top Up',
                        0 => 'Barang'
                    ])
                    ->reactive()
                    ->required()
                    ->afterStateUpdated(fn ($state) => $jenisTransaksi = $state),
                Select::make('inv_barang_cabang_id')
                    ->label('Nama Barang')
                    ->options(InventoryBarangCabang::join('inventory_barang', 'inventory_barang_cabang.inventory_barang_id', '=', 'inventory_barang.id')
                        ->selectRaw('CONCAT(inventory_barang.nama, " - STOK : ", inventory_barang_cabang.stok) as nama, inventory_barang_cabang.id')
                        ->pluck('nama', 'id'))
                    ->required()
                    ->columnSpanFull()
                    ->hidden(fn ($get) => $get('is_sumber_dana') != 0 || $get('is_sumber_dana') == null),
                Select::make('sumber_dana')
                    ->label('Sumber Dana')
                    ->options(SumberDana::where('cabang_id', auth()->user()->cabang_id)->get()->pluck('nama', 'id'))
                    ->required()
                    ->columnSpanFull()
                    ->hidden(fn ($get) => $get('is_sumber_dana') != 1 || $get('is_sumber_dana') == null),
                TextInput::make('harga')
                    ->numeric()
                    ->default(1)
                    ->required()
                    ->hidden(fn ($get) => $get('is_sumber_dana') == null),
                TextInput::make('jumlah')
                    ->numeric()
                    ->default(1)
                    ->required()
                    ->hidden(fn ($get) => $get('is_sumber_dana') == null),
                Textarea::make('keterangan')
                    ->columnSpanFull()
                    ->hidden(fn ($get) => $get('is_sumber_dana') == null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => Pages\ListTransaksis::route('/'),
            'create' => Pages\CreateTransaksi::route('/create'),
            'edit' => Pages\EditTransaksi::route('/{record}/edit'),
        ];
    }
}
