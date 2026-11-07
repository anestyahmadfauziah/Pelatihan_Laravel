<?php

namespace App\Filament\Resources\BahanPangans\Pages;

use App\Filament\Resources\BahanPangans\BahanPanganResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBahanPangans extends ListRecords
{
    protected static string $resource = BahanPanganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
