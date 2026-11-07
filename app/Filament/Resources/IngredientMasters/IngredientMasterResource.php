<?php

namespace App\Filament\Resources\IngredientMasters;

use App\Filament\Resources\IngredientMasters\Pages\CreateIngredientMaster;
use App\Filament\Resources\IngredientMasters\Pages\EditIngredientMaster;
use App\Filament\Resources\IngredientMasters\Pages\ListIngredientMasters;
use App\Filament\Resources\IngredientMasters\Schemas\IngredientMasterForm;
use App\Filament\Resources\IngredientMasters\Tables\IngredientMastersTable;
use App\Models\IngredientMaster;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class IngredientMasterResource extends Resource
{
    protected static ?string $model = IngredientMaster::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $navigationLabel = 'Data Master Bahan';

    protected static ?string $modelLabel = 'Bahan Pangan';

    protected static ?string $pluralModelLabel = 'Data Master Bahan Pangan';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return IngredientMasterForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return IngredientMastersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListIngredientMasters::route('/'),
            'create' => CreateIngredientMaster::route('/create'),
            'edit' => EditIngredientMaster::route('/{record}/edit'),
        ];
    }
}