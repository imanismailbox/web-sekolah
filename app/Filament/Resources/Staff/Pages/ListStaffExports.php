<?php

namespace App\Filament\Resources\Staff\Pages;

use App\Filament\Resources\Staff\Exports\StaffExporter;
use App\Filament\Resources\Staff\StaffResource;
use Filament\Actions\Action;
use Filament\Actions\Exports\Enums\ExportFormat;
use Filament\Actions\Exports\Models\Export;
use Filament\Resources\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class ListStaffExports extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string $resource = StaffResource::class;

    protected string $view = 'filament.resources.staff.pages.list-staff-exports';

    protected static ?string $title = 'Riwayat Export Guru/Pegawai';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Export::query()
                    ->where('exporter', StaffExporter::class)
                    ->where('user_id', auth()->id())
                    ->latest(),
            )
            ->columns([
                TextColumn::make('file_name')
                    ->label('Berkas')
                    ->placeholder('-'),
                TextColumn::make('successful_rows')
                    ->label('Berhasil'),
                TextColumn::make('total_rows')
                    ->label('Total'),
                TextColumn::make('completed_at')
                    ->label('Selesai')
                    ->dateTime('d M Y H:i')
                    ->placeholder('Sedang diproses'),
            ])
            ->recordActions([
                Action::make('downloadCsv')
                    ->label('Unduh CSV')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn (Export $record): string => route('filament.exports.download', ['export' => $record, 'format' => ExportFormat::Csv->value]))
                    ->visible(fn (Export $record): bool => $record->getFileDisk()->exists($record->getFileDirectory())),
                Action::make('downloadXlsx')
                    ->label('Unduh XLSX')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn (Export $record): string => route('filament.exports.download', ['export' => $record, 'format' => ExportFormat::Xlsx->value]))
                    ->visible(fn (Export $record): bool => $record->getFileDisk()->exists($record->getFileDirectory().DIRECTORY_SEPARATOR."{$record->file_name}.xlsx")),
            ])
            ->defaultSort('completed_at', 'desc');
    }
}
