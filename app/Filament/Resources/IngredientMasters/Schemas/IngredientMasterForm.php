<?php

namespace App\Filament\Resources\IngredientMasters\Schemas;

use App\Models\IngredientCategory;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;

class IngredientMasterForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('category_id')
                    ->label('Kategori Bahan')
                    ->options(
                        IngredientCategory::pluck('name', 'id')
                    )
                    ->required()
                    ->searchable(),

                TextInput::make('name')
                    ->label('Nama Bahan Pangan')
                    ->required()
                    ->maxLength(255),

                TextInput::make('default_unit')
                    ->label('Satuan Default')
                    ->placeholder('Contoh: gram, kg, buah')
                    ->required(),

                FileUpload::make('image_path')
                    ->label('Gambar Bahan Pangan')
                    ->image()
                    ->directory('ingredients')
                    ->disk('public'),

                TextInput::make('calories_per_100g')
                    ->label('Kalori per 100 gram')
                    ->numeric()
                    ->minValue(0),

                TextInput::make('protein_g')
                    ->label('Protein (gram)')
                    ->numeric()
                    ->minValue(0),

                TextInput::make('fat_g')
                    ->label('Lemak (gram)')
                    ->numeric()
                    ->minValue(0),

                TextInput::make('carbs_g')
                    ->label('Karbohidrat (gram)')
                    ->numeric()
                    ->minValue(0),

                TextInput::make('iron_mg')
                    ->label('Zat Besi (mg)')
                    ->numeric()
                    ->minValue(0),

                TextInput::make('zinc_mg')
                    ->label('Zinc (mg)')
                    ->numeric()
                    ->minValue(0),

                TextInput::make('vitamin_a_mcg')
                    ->label('Vitamin A (mcg)')
                    ->numeric()
                    ->minValue(0),

                TextInput::make('vitamin_c_mg')
                    ->label('Vitamin C (mg)')
                    ->numeric()
                    ->minValue(0),
            ]);
    }
}
