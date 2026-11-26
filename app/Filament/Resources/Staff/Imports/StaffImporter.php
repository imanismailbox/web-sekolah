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
                ->label('Nama')
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
            ImportColumn::make('subject')
                ->label('Mapel')
                ->rules(['nullable', 'max:255']),
        ];
    }

    public function resolveRecord(): Staff
    {
        return new Staff;
    }

    /**
     * Blank CSV cells arrive as empty strings, which fail `nullable` checks; treat them as null.
     */
    public function castData(): void
    {
        parent::castData();

        $this->data = array_map(fn (mixed $value): mixed => $value === '' ? null : $value, $this->data);
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
