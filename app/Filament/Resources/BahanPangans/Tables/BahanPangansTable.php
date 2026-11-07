<?php

namespace App\Filament\Resources\BahanPangans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
namespace App\Filament\Resources\BahanPangans;

class BahanPangansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('category_id')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('default_unit')
                    ->searchable(),
                TextColumn::make('calories_per_100g')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('protein_g')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('fat_g')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('carbs_g')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('iron_mg')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('zinc_mg')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('vitamin_a_mcg')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('vitamin_c_mg')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
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
