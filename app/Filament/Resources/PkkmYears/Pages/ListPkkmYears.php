<?php

namespace App\Filament\Resources\PkkmYears\Pages;

use App\Filament\Resources\PkkmYears\PkkmYearResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPkkmYears extends ListRecords
{
    protected static string $resource = PkkmYearResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
