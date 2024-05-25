<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\SumberDanaResource\Pages;
use App\Models\SumberDana;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Select;
use App\Models\Cabang;
use Filament\Support\Assets\Js;
use Filament\Support\RawJs;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Mu;
use Malzariey\FilamentDaterangepickerFilter\Filters\DateRangeFilter;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;

class SumberDanaResource extends Resource
{
    protected static ?string $model = SumberDana::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $pluralModelLabel = 'Sumber Dana';

    protected static ?string $navigationLabel = 'Sumber Dana';

    protected static ?string $navigationGroup = 'Keuangan';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('kode')->required()->unique(ignoreRecord: true),
                TextInput::make('nama')->required(),
                TextInput::make('no')
                    ->tel()
                    ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/')
                    ->required(),
                TextInput::make('saldo')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()
                    ->required(),
                Select::make('cabang_id')
                    ->label('Cabang')
                    ->options(Cabang::query()->orderBy('nama')->pluck('nama', 'id'))
                    ->searchable()
                    ->required(),
            ]);
    }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode')
                    ->searchable(),
                TextColumn::make('nama')
                    ->searchable(),
                TextColumn::make('no')
                    ->searchable(),
                TextColumn::make('saldo'),
                TextColumn::make('cabang.nama')
                    ->label('Cabang')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->date(),
            ])
            ->filters([
                SelectFilter::make('cabang')
                    ->label('Cabang')
                    ->relationship('cabang', 'nama')
                    ->options(Cabang::all()->pluck('nama', 'id'))
                    ->placeholder('All Cabangs')
                    ->searchable()
                    ->multiple(),
                DateRangeFilter::make('created_at'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->headerActions([
                ExportAction::make()->exports([
                    ExcelExport::make()->fromTable()
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])->paginated();
    }
    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSumberDanas::route('/'),
            'create' => Pages\CreateSumberDana::route('/create'),
            'edit' => Pages\EditSumberDana::route('/{record}/edit'),
        ];
    }
}
