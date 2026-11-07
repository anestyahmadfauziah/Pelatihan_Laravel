<?php

namespace App\Filament\Resources\IngredientMasters\Pages;

use App\Filament\Resources\IngredientMasters\IngredientMasterResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditIngredientMaster extends EditRecord
{
    protected static string $resource = IngredientMasterResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
