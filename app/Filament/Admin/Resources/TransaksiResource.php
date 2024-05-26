<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TransaksiResource\Pages;
use App\Filament\Admin\Resources\TransaksiResource\RelationManagers;
use App\Models\Cabang;
use App\Models\InventoryBarangCabang;
use App\Models\KategoriPembayaran;
use App\Models\SumberDana;
use App\Models\Transaksi;
use DateTime;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
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

    protected static ?int $navigationSort = 9;


    public static function form(Form $form): Form
    {

        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make('Create')
                        ->schema([
                            DateTimePicker::make('tgl_transaksi')
                                ->label('Tanggal Transaksi')
                                ->default(now())
                                ->required()
                                ->reactive(),
                            Select::make('cabang_id')
                                ->options(Cabang::all()->pluck('nama', 'id'))
                                ->default(auth()->user()->cabang_id)
                                ->disabled()
                                ->required()
                                ->reactive(),
                            Select::make('is_sumber_dana')
                                ->label('Jenis Transaksi')
                                ->options([
                                    1 => 'Tagihan/Top Up',
                                    0 => 'Barang'
                                ])
                                ->reactive()
                                ->required()
                                ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                    $set('sumber_dana', null);
                                    $set('kategori_pembayaran_id', null);
                                    $set('is_harga_flexible', null);
                                    $set('harga_jual', null);
                                    $set('jumlah', 1);
                                    $set('harga_beli', 0);
                                    $set('keterangan', '');
                                    $set('inv_barang_cabang_id', null);
                                    $set('tgl_transaksi_info', $get('tgl_transaksi'));
                                }),
                            Select::make('inv_barang_cabang_id')
                                ->label('Nama Barang')
                                ->options(InventoryBarangCabang::join('inventory_barang', 'inventory_barang_cabang.inventory_barang_id', '=', 'inventory_barang.id')
                                    ->selectRaw('CONCAT(inventory_barang.nama, " - STOK : ", inventory_barang_cabang.stok) as nama, inventory_barang_cabang.id')
                                    ->where('inventory_barang_cabang.cabang_id', auth()->user()->cabang_id)
                                    ->pluck('nama', 'id'))
                                ->required()
                                ->columnSpanFull()
                                ->reactive()
                                ->searchable()
                                ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                    $inventoryBarang = InventoryBarangCabang::find($state);
                                    $set('inv_barang_cabang_nama', $inventoryBarang->nama);
                                    $set('harga_jual', $inventoryBarang->harga_jual);
                                    $set('harga_jual_info', number_format($inventoryBarang->harga_jual));
                                    $set('harga_beli', $inventoryBarang->harga_beli);
                                    $set('qty', 1);
                                    // self::performCalculation($get, $set);
                                })
                                ->hidden(fn ($get) => $get('is_sumber_dana') != 0 || $get('is_sumber_dana') === null),
                            Select::make('sumber_dana_id')
                                ->label('Sumber Dana')
                                ->options(SumberDana::where('cabang_id', auth()->user()->cabang_id)->get()->pluck('nama', 'id'))
                                ->required()
                                ->searchable()
                                ->columnSpanFull()
                                ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                    $sumberDana = SumberDana::find($state);
                                    $set('sumber_dana_nama', $sumberDana->nama);
                                })
                                ->hidden(fn ($get) => $get('is_sumber_dana') != 1 || $get('is_sumber_dana') === null),
                            Select::make('kategori_pembayaran_id')
                                ->label('Kategori Pembayaran')
                                ->relationship('kategoriPembayaran', 'nama')
                                ->searchable()
                                ->required()
                                ->reactive()
                                ->columnSpanFull()
                                ->hidden(fn ($get) => $get('is_sumber_dana') != 1 || $get('is_sumber_dana') === null)
                                ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                    $kategoriPembayaran = KategoriPembayaran::find($state);
                                    $set('is_harga_flexible', $kategoriPembayaran->is_harga_flexible);
                                    $set('laba', number_format($kategoriPembayaran->laba));
                                    $set('harga_jual', number_format($kategoriPembayaran->harga_jual));
                                    $set('harga_beli', number_format($kategoriPembayaran->harga_beli));
                                    // $set('total_harga', $kategoriPembayaran->is_harga_flexible ? number_format($kategoriPembayaran->laba) : number_format($kategoriPembayaran->harga_jual));
                                    $set('kategori_pembayaran_nama', $kategoriPembayaran->nama);
                                    $set('qty_info', 1);
                                }),
                            TextInput::make('is_harga_flexible')
                                ->label('Is Harga Flexible')
                                ->hidden()
                                ->reactive(),
                            TextInput::make('harga_jual_info')
                                ->label('Harga Jual')
                                ->numeric()
                                ->default(0)
                                ->required()
                                ->mask(RawJs::make('$money($input)'))
                                ->stripCharacters(',')
                                ->reactive()
                                ->disabled(fn ($get) => true) // Always disabled but still submits data
                                ->hidden(fn ($get) => $get('is_harga_flexible') !== 0 && $get('inv_barang_cabang_id') == null),
                            TextInput::make('harga_jual')
                                ->label('Harga Jual')
                                ->numeric()
                                ->default(0)
                                ->required()
                                ->mask(RawJs::make('$money($input)'))
                                ->stripCharacters(',')
                                ->reactive()
                                ->hidden(),
                            Hidden::make('qty')->default(1),
                            TextInput::make('harga_beli')
                                ->label('Jumlah Pembayaran')
                                ->numeric()
                                ->required()
                                ->mask(RawJs::make('$money($input)'))
                                ->stripCharacters(',')
                                ->reactive()
                                ->hidden(fn ($get) => $get('is_harga_flexible') !== 1),
                            TextInput::make('no_transaksi')
                                ->label('NO TUJUAN/TOP UP')
                                ->required()
                                ->reactive()
                                ->columnSpanFull()
                                ->hidden(fn ($get) => $get('is_sumber_dana') != 1 || $get('is_sumber_dana') === null),
                            Textarea::make('keterangan')
                                ->columnSpanFull()
                                ->hidden(fn ($get) => $get('is_sumber_dana') === null),

                            Hidden::make('user_id')->default(auth()->id()),
                            Hidden::make('cabang_id')->default(auth()->user()->cabang_id),
                            Hidden::make('harga_jual'),
                            Hidden::make('harga_beli'),
                            Hidden::make('qty')->default(1),
                            Hidden::make('total_harga'),
                            Hidden::make('tgl_transaksi'),
                        ])->afterValidation(function ($state, callable $set, callable $get) {

                            if ($get('is_harga_flexible') == 1) {
                                $set('harga_jual', self::changeFormatToInt($get('harga_beli')) + self::changeFormatToInt($get('laba')));
                                $set('total_harga', self::changeFormatToInt($get('harga_beli')) + self::changeFormatToInt($get('laba')));
                            } else {
                                $set('total_harga', self::changeFormatToInt($get('harga_jual')) * $get('qty'));
                            }

                            $set('harga_beli_info', $get('harga_beli'));
                            $set('qty_info', $get('qty'));
                            $set('harga_jual_info', $get('harga_jual'));
                            $set('keterangan_info', $get('keterangan'));
                            // dd([$state, $set, $get]);
                        }),
                    Wizard\Step::make('All Detail')
                        ->schema([
                            TextInput::make('tgl_transaksi_info')->disabled()->label('Tanggal Transaksi'),
                            TextInput::make('cabang_nama')
                                ->disabled()
                                ->label('Cabang')
                                ->reactive()
                                ->afterStateHydrated(function ($state, callable $set, callable $get) {
                                    $cabang = Cabang::find($get('cabang_id'));
                                    $set('cabang_nama', $cabang->nama);
                                }),
                            TextInput::make('sumber_dana_nama')
                                ->disabled()
                                ->label('Sumber Dana')
                                ->reactive()
                                ->hidden(fn ($get) => $get('is_sumber_dana') != 1 || $get('is_sumber_dana') === null),
                            TextInput::make('inv_barang_cabang_nama')
                                ->disabled()
                                ->label('Nama Barang')
                                ->default(fn ($get) => $get('inv_barang_cabang_nama'))
                                ->hidden(fn ($get) => $get('is_sumber_dana') != 0 || $get('is_sumber_dana') === null),
                            TextInput::make('kategori_pembayaran_nama')->disabled()->label('Kategori Pembayaran'),
                            TextInput::make('harga_jual_info')
                                ->disabled()
                                ->label('Harga Jual')
                                ->reactive(),
                            TextInput::make('total_harga_info')
                                ->disabled()
                                ->label('Total Harga')
                                ->mask(RawJs::make('$money($input)'))
                                ->reactive(),
                            // ->afterStateUpdated(function ($state, callable $set, callable $get) {
                            //     // $cabang = Cabang::find($get('cabang_id'));

                            //     $set('harga_jual_detail', $get('harga_beli') * $get('qty'));
                            //     dd([$get('harga_beli'), $get('qty')]);
                            // }),
                            TextInput::make('harga_beli_info')->disabled()->label('Harga Beli'),
                            TextInput::make('qty_info')->disabled()->label('Quantity'),
                            Textarea::make('keterangan_info')->disabled()->label('Keterangan'),
                        ])
                ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('is_sumber_dana')
                    ->label('Jenis Transaksi')
                    ->formatStateUsing(fn ($state) => $state ? 'Tagihan/Top Up' : 'Barang'),
                TextColumn::make('tgl_transaksi')
                    ->searchable(),
                TextColumn::make('cabang.nama')
                    ->searchable(),
                TextColumn::make('sumberDana.nama')->label('Sumber Dana')
                    ->searchable(),
                TextColumn::make('barang')
                    ->label('Pembelian')
                    ->getStateUsing(fn ($record) => $record->is_sumber_dana ? $record->kategoriPembayaran->nama : $record->invBarangCabang->inventory_barang->nama)
                    ->searchable(query: function (Builder $query, string $search): Builder {
                        return $query
                            ->when($search, function ($query) use ($search) {
                                $query->whereHas('invBarangCabang.inventory_barang', function ($query) use ($search) {
                                    $query->where('nama', 'like', '%' . $search . '%');
                                })
                                    ->orWhereHas('kategoriPembayaran', function ($query) use ($search) {
                                        $query->where('nama', 'like', '%' . $search . '%');
                                    });
                            });
                    }),
                TextColumn::make('qty')->label('Quantity')
                    ->searchable(),
                TextColumn::make('harga_jual')->label('Harga Jual')
                    ->formatStateUsing(fn ($state) => number_format($state, 2))
                    ->searchable(),
                TextColumn::make('total_harga')->label('Total Harga')
                    ->formatStateUsing(fn ($state) => number_format($state, 2))
                    ->searchable(),
                TextColumn::make('user.name')
                    ->label('Dibuat oleh')
                    ->searchable(),
            ])
            ->filters([
                SelectFilter::make('cabang_id')
                    ->label('Cabang')
                    ->options(Cabang::all()->pluck('nama', 'id'))
                    ->searchable()
                    ->default(auth()->user()->cabang_id),
                SelectFilter::make('is_sumber_dana')
                    ->label('Kategori Pembayaran')
                    ->searchable()
                    ->options(
                        [
                            1 => 'Tagihan/Top Up',
                            0 => 'Barang'
                        ]
                    ),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->form([
                    TextInput::make('no_transaksi')
                        ->label('Nomor Transaksi')
                        ->disabled(),
                    DateTimePicker::make('tgl_transaksi')
                        ->label('Tanggal Transaksi')
                        ->disabled(),
                    Select::make('cabang_id')
                        ->relationship('cabang', 'nama')
                        ->label('Cabang')
                        ->disabled(),
                    Select::make('sumber_dana_id')
                        ->relationship('sumberDana', 'nama')
                        ->label('Sumber Dana')
                        ->visible(fn ($record) => $record->is_sumber_dana),
                    Select::make('kategori_pembayaran_id')
                        ->relationship('kategoriPembayaran', 'nama')
                        ->label('Kategori Pembayaran')
                        ->visible(fn ($record) => $record->is_sumber_dana),
                    Select::make('inv_barang_cabang_id')
                        ->options(InventoryBarangCabang::join('inventory_barang', 'inventory_barang_cabang.inventory_barang_id', '=', 'inventory_barang.id')
                            ->selectRaw('CONCAT(inventory_barang.nama, " - STOK : ", inventory_barang_cabang.stok) as nama, inventory_barang_cabang.id')
                            ->where('inventory_barang_cabang.cabang_id', auth()->user()->cabang_id)
                            ->pluck('nama', 'id'))
                        ->label('Inventory Barang')
                        ->visible(fn ($record) => $record->inv_barang_cabang_id),
                    Textarea::make('keterangan')
                        ->label('Keterangan'),
                    TextInput::make('harga_beli')
                        ->label('Harga Beli')
                        ->numeric(),
                    TextInput::make('harga_jual')
                        ->label('Harga Jual')
                        ->numeric(),
                    TextInput::make('qty')
                        ->label('Quantity')
                        ->numeric(),
                ]),
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
            // 'create' => Pages\CreateTransaksi::route('/create'),
            // 'edit' => Pages\EditTransaksi::route('/{record}/edit'),
        ];
    }

    public static function changeFormatToInt($data)
    {
        $hargaBeli = str_replace(',', '', $data);
        return (int)$hargaBeli;
    }
}
