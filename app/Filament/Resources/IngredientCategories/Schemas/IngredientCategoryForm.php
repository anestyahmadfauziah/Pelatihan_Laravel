<?php

namespace App\Filament\Resources\IngredientCategories\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;

class IngredientCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
         return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Kategori')
                    ->placeholder('Contoh: Sayur')
                    ->required()
                    ->maxLength(50)
                    ->unique(ignoreRecord: true),
            ]);
    }
}
