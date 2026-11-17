<?php

namespace App\Filament\Resources\PkkmYears\Pages;

use App\Actions\DuplicatePkkmYear;
use App\Filament\Resources\PkkmYears\PkkmYearResource;
use App\Models\PkkmYear;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Icons\Heroicon;

class ListPkkmYears extends ListRecords
{
    protected static string $resource = PkkmYearResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('duplicate')
                ->label('Duplikat dari Tahun…')
                ->icon(Heroicon::OutlinedDocumentDuplicate)
                ->color('gray')
                ->visible(fn (): bool => PkkmYearResource::canCreate())
                ->modalDescription('Salin komponen, unsur, dan indikator dari tahun sebelumnya. Bukti dukung tidak ikut disalin.')
                ->schema([
                    Select::make('source_id')
                        ->label('Tahun sumber')
                        ->options(fn (): array => PkkmYear::query()->orderByDesc('year')->pluck('year', 'id')->all())
                        ->default(fn (): ?int => PkkmYear::query()->orderByDesc('year')->value('id'))
                        ->required(),
                    TextInput::make('year')
                        ->label('Tahun baru')
                        ->required()
                        ->integer()
                        ->minValue(2000)
                        ->maxValue(2100)
                        ->default(now()->year)
                        ->unique(PkkmYear::class, 'year'),
                ])
                ->action(function (array $data, DuplicatePkkmYear $duplicatePkkmYear): void {
                    $year = $duplicatePkkmYear->handle(
                        PkkmYear::query()->findOrFail($data['source_id']),
                        (int) $data['year'],
                    );

                    Notification::make()
                        ->title("PKKM {$year->year} berhasil dibuat")
                        ->success()
                        ->send();

                    $this->redirect(PkkmYearResource::getUrl('edit', ['record' => $year]));
                }),
            CreateAction::make(),
        ];
    }
}
