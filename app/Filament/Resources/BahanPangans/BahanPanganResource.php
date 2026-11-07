<?php

namespace App\Filament\Resources\BahanPangans;

use App\Filament\Resources\BahanPangans\Pages\CreateBahanPangan;
use App\Filament\Resources\BahanPangans\Pages\EditBahanPangan;
use App\Filament\Resources\BahanPangans\Pages\ListBahanPangans;
use App\Filament\Resources\BahanPangans\Schemas\BahanPanganForm;
use App\Filament\Resources\BahanPangans\Tables\BahanPangansTable;
use App\Models\BahanPangan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class BahanPanganResource extends Resource
{
    protected static ?string $model = BahanPangan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return BahanPanganForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BahanPangansTable::configure($table);
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
            'index' => ListBahanPangans::route('/'),
            'create' => CreateBahanPangan::route('/create'),
            'edit' => EditBahanPangan::route('/{record}/edit'),
        ];
    }
}
