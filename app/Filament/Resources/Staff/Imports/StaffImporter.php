<?php

namespace App\Filament\Resources\Staff\Imports;

use App\Enums\StaffType;
use App\Models\Staff;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Validation\Rule;

class StaffImporter extends Importer
{
    protected static ?string $model = Staff::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('name')
                ->label('Nama Lengkap')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('type')
                ->label('Jenis')
                ->requiredMapping()
                ->examples(['guru', 'pegawai'])
                ->castStateUsing(fn (?string $state): ?string => match (strtolower(trim((string) $state))) {
                    'guru' => StaffType::Teacher->value,
                    'pegawai', 'karyawan' => StaffType::Employee->value,
                    default => $state,
                })
                ->rules(['required', Rule::enum(StaffType::class)]),
            ImportColumn::make('position')
                ->label('Jabatan')
                ->rules(['max:255']),
            ImportColumn::make('subject')
                ->label('Mata Pelajaran')
                ->rules(['max:255']),
            ImportColumn::make('education')
                ->label('Pendidikan Terakhir')
                ->rules(['max:255']),
            ImportColumn::make('nip')
                ->label('NIP')
                ->rules(['max:30']),
            ImportColumn::make('nuptk')
                ->label('NUPTK')
                ->rules(['max:30']),
            ImportColumn::make('email')
                ->label('Email')
                ->rules(['email', 'max:255']),
            ImportColumn::make('phone')
                ->label('Telepon')
                ->rules(['max:255']),
            ImportColumn::make('is_active')
                ->label('Aktif')
                ->boolean(),
        ];
    }

    /**
     * Rows with an existing NIP update that record instead of creating a duplicate.
     */
    public function resolveRecord(): Staff
    {
        $nip = $this->data['nip'] ?? null;

        return filled($nip) ? Staff::firstOrNew(['nip' => $nip]) : new Staff;
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Impor guru & pegawai selesai, '.number_format($import->successful_rows).' baris berhasil diimpor.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' '.number_format($failedRowsCount).' baris gagal diimpor.';
        }

        return $body;
    }
}
