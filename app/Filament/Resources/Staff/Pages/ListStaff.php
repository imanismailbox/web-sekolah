<?php

namespace App\Filament\Resources\Staff\Pages;

use App\Filament\Resources\Staff\Imports\StaffImporter;
use App\Filament\Resources\Staff\StaffResource;
use Filament\Actions\CreateAction;
use Filament\Actions\ImportAction;
use Filament\Resources\Pages\ListRecords;

class ListStaff extends ListRecords
{
    protected static string $resource = StaffResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ImportAction::make()
                ->label('Import Guru/Pegawai')
                ->modalHeading('Import Guru/Pegawai')
                ->importer(StaffImporter::class)
                ->visible(fn (): bool => StaffResource::canCreate()),
            CreateAction::make(),
        ];
    }
}
