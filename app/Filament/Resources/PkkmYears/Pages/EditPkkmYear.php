<?php

namespace App\Filament\Resources\PkkmYears\Pages;

use App\Filament\Resources\PkkmYears\PkkmYearResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPkkmYear extends EditRecord
{
    protected static string $resource = PkkmYearResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
