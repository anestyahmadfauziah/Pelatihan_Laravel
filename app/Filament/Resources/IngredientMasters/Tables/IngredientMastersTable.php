<?php

namespace App\Filament\Resources\IngredientMasters\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;

class IngredientMastersTable
{
     public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                    ->label('ID')
                    ->sortable(),

                TextColumn::make('image_path')
                    ->label('Gambar')
                    ->formatStateUsing(fn ($state) => $state
                        ? '<img src="' . e($state) . '" width="55" height="55" style="object-fit: cover; border-radius: 8px;">'
                        : '-'
                    )
                    ->html(),

                TextColumn::make('name')
                    ->label('Nama Bahan')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->sortable(),

                TextColumn::make('default_unit')
                    ->label('Satuan')
                    ->sortable(),

                TextColumn::make('calories_per_100g')
                    ->label('Kalori / 100g')
                    ->numeric(decimalPlaces: 2)
                    ->sortable(),

                TextColumn::make('protein_g')
                    ->label('Protein (g)')
                    ->numeric(decimalPlaces: 2),

                TextColumn::make('carbs_g')
                    ->label('Karbohidrat (g)')
                    ->numeric(decimalPlaces: 2),
            ])
            ->filters([])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}