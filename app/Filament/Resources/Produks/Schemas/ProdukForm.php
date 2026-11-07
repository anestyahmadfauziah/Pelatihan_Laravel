<?php

namespace App\Filament\Resources\Produks\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ProdukForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('kode_sku')
                    ->required(),
                TextInput::make('nama')
                    ->required(),
                TextInput::make('harga_jual')
                    ->required()
                    ->numeric()
                    ->prefix('Rp'),
                TextInput::make('stok')
                    ->required()
                    ->numeric()
                    ->default(0),

            ]);
    }
}
