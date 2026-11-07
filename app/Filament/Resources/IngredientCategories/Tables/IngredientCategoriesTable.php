<?php

namespace App\Filament\Resources\IngredientCategories\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use App\Models\IngredientCategory;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class IngredientCategoriesTable
{
    public static function configure(Table $table): Table
    {
       return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                TextColumn::make('name')
                    ->label('Nama Kategori')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('ingredients_count')
                    ->label('Jumlah Bahan')
                    ->counts('ingredients'),
            ])
            ->recordActions([
    EditAction::make()
        ->label('Ubah')
        ->icon('heroicon-o-pencil-square')
        ->color('primary')
        ->size('sm'),

]);
    }
}
