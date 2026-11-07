<?php

namespace App\Filament\Resources\Branches\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use Filament\Forms\Components\ViewField;

class BranchForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama')
                    ->label('Nama')
                    ->required(),

                Textarea::make('alamat')
                    ->label('Alamat')
                    ->required()
                    ->columnSpanFull(),

                TextInput::make('telepon')
                    ->label('Telepon')
                    ->tel(),

                TextInput::make('latitude')
                    ->label('Latitude')
                    ->required()
                    ->numeric(),
                Select::make('jenis')
    ->label('Jenis Cabang')
    ->options([
        'toko' => 'Toko',
        'bengkel' => 'Bengkel',
    ])
    ->default('toko')
    ->required(),

                TextInput::make('longitude')
                    ->label('Longitude')
                    ->required()
                    ->numeric(),

                ViewField::make('map_picker')
                    ->label('Pilih Lokasi pada Peta')
                    ->view('filament.forms.components.branch-map')
                    ->dehydrated(false)
                    ->columnSpanFull(),
            ]);
    }
}