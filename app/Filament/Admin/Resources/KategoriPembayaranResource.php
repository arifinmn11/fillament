<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\KategoriPembayaranResource\Pages;
use App\Filament\Admin\Resources\KategoriPembayaranResource\RelationManagers;
use App\Models\KategoriPembayaran;
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

class KategoriPembayaranResource extends Resource
{
    protected static ?string $model = KategoriPembayaran::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $modelLabel = 'Kategori Pembayaran';

    protected static ?string $pluralModelLabel = 'Kategori Pembayaran';

    protected static ?string $navigationLabel = 'Kategori Pembayaran';

    protected static ?string $navigationGroup = 'Master Data';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Radio::make('is_harga_flexible')
                    ->label('Laba Fleksibel')
                    ->boolean("Tidak Tetap", "Tetap")
                    ->default(false)
                    ->reactive()
                    ->required()
                    ->default(true)
                    ->columnSpanFull(),
                TextInput::make('kode'),
                TextInput::make('nama'),
                TextInput::make('harga_beli')->default(0)
                    ->reactive()
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()
                    ->rule('required_if:is_harga_flexible,0')
                    ->reactive()
                    ->hidden(fn ($get) => $get('is_harga_flexible')),
                TextInput::make('harga_jual')->default(0)
                    ->reactive()
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()
                    ->rule('required_if:is_harga_flexible,0')
                    ->reactive()
                    ->hidden(fn ($get) => $get('is_harga_flexible')),
                TextInput::make('laba')->default(0)
                    ->label('Laba')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()
                    ->reactive()
                    ->rule('required_if:is_harga_flexible,1',)
                    ->hidden(fn ($get) => $get('is_harga_flexible') == 0)
                // ->hidden(fn ($get) => $get('is_harga_flexible') == null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('is_harga_flexible')
                    ->label('Jenis')
                    ->formatStateUsing(fn ($state) => $state ? 'TIDKA TETAP' : 'TETAP'),
                TextColumn::make('kode'),
                TextColumn::make('nama'),
                TextColumn::make('harga_beli'),
                TextColumn::make('harga_jual'),
                TextColumn::make('laba'),
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
            'index' => Pages\ListKategoriPembayarans::route('/'),
            'create' => Pages\CreateKategoriPembayaran::route('/create'),
            'edit' => Pages\EditKategoriPembayaran::route('/{record}/edit'),
        ];
    }
}
