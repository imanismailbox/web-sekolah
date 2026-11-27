<?php

namespace App\Filament\Resources\Staff\Pages;

use App\Filament\Resources\Staff\Exports\StaffExporter;
use App\Filament\Resources\Staff\Imports\StaffImporter;
use App\Filament\Resources\Staff\StaffResource;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Actions\ExportAction;
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
            ExportAction::make()
                ->label('Export Guru/Pegawai')
                ->modalHeading('Export Guru/Pegawai')
                ->exporter(StaffExporter::class)
                ->visible(fn (): bool => StaffResource::canViewAny()),
            Action::make('exportHistory')
                ->label('Riwayat Export')
                ->url(StaffResource::getUrl('exports'))
                ->visible(fn (): bool => StaffResource::canViewAny()),
            CreateAction::make(),
        ];
    }
}
