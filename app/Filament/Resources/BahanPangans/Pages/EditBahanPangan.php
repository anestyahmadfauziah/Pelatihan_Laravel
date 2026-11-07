<?php

namespace App\Filament\Resources\BahanPangans\Pages;

use App\Filament\Resources\BahanPangans\BahanPanganResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditBahanPangan extends EditRecord
{
    protected static string $resource = BahanPanganResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
