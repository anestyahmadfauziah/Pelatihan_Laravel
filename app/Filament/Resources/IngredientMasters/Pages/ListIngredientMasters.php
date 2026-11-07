<?php

namespace App\Filament\Resources\IngredientMasters\Pages;

use App\Filament\Resources\IngredientMasters\IngredientMasterResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListIngredientMasters extends ListRecords
{
    protected static string $resource = IngredientMasterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
