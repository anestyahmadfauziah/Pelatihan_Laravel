<?php

namespace App\Filament\Resources\BahanPangans\Schemas;

use App\Models\Category;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Schema;

class BahanPanganForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('category_id')
                    ->label('Kategori')
                    ->options(Category::pluck('nama', 'id'))
                    ->searchable()
                    ->required(),

                TextInput::make('name')
                    ->label('Nama Bahan Pangan')
                    ->required(),

                TextInput::make('default_unit')
                    ->label('Satuan')
                    ->required(),

                FileUpload::make('image_path')
                    ->label('Gambar Bahan Pangan')
                    ->image()
                    ->directory('bahan-pangan')
                    ->nullable(),

                TextInput::make('calories_per_100g')
                    ->label('Kalori per 100g')
                    ->numeric()
                    ->default(0),

                TextInput::make('protein_g')
                    ->label('Protein (g)')
                    ->numeric()
                    ->default(0),

                TextInput::make('fat_g')
                    ->label('Lemak (g)')
                    ->numeric()
                    ->default(0),

                TextInput::make('carbs_g')
                    ->label('Karbohidrat (g)')
                    ->numeric()
                    ->default(0),

                TextInput::make('iron_mg')
                    ->label('Zat Besi (mg)')
                    ->numeric()
                    ->default(0),

                TextInput::make('zinc_mg')
                    ->label('Zinc (mg)')
                    ->numeric()
                    ->default(0),

                TextInput::make('vitamin_a_mcg')
                    ->label('Vitamin A (mcg)')
                    ->numeric()
                    ->default(0),

                TextInput::make('vitamin_c_mg')
                    ->label('Vitamin C (mg)')
                    ->numeric()
                    ->default(0),
            ]);
    }
}