<?php

namespace App\Filament\Resources\Staff\Exports;

use App\Enums\StaffType;
use App\Models\Staff;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class StaffExporter extends Exporter
{
    protected static ?string $model = Staff::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('name')
                ->label('Nama'),
            ExportColumn::make('nip')
                ->label('NIP'),
            ExportColumn::make('nuptk')
                ->label('NUPTK'),
            ExportColumn::make('type')
                ->label('Jenis')
                ->formatStateUsing(fn (StaffType $state): string => $state->getLabel()),
            ExportColumn::make('position')
                ->label('Jabatan'),
            ExportColumn::make('subject')
                ->label('Mapel'),
            ExportColumn::make('education')
                ->label('Pendidikan'),
            ExportColumn::make('email')
                ->label('Email'),
            ExportColumn::make('phone')
                ->label('Telepon'),
            ExportColumn::make('sort')
                ->label('Urutan'),
            ExportColumn::make('is_active')
                ->label('Status')
                ->formatStateUsing(fn (bool $state): string => $state ? 'Aktif' : 'Nonaktif'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Ekspor guru & pegawai selesai, '.number_format($export->successful_rows).' baris berhasil diekspor.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' '.number_format($failedRowsCount).' baris gagal diekspor.';
        }

        return $body;
    }
}
