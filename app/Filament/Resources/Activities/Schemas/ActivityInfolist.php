<?php

namespace App\Filament\Resources\Activities\Schemas;

use App\Filament\Resources\Activities\ActivityResource;
use Filament\Infolists\Components\KeyValueEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Spatie\Activitylog\Models\Activity;

class ActivityInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns(3)
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('description')
                            ->label('Deskripsi'),
                        TextEntry::make('event')
                            ->label('Aksi')
                            ->badge(),
                        TextEntry::make('created_at')
                            ->label('Waktu')
                            ->dateTime('d M Y H:i:s'),
                        TextEntry::make('subject_type')
                            ->label('Objek')
                            ->formatStateUsing(fn (?string $state, Activity $record): string => ActivityResource::subjectLabel($state).' #'.$record->subject_id),
                        TextEntry::make('causer.name')
                            ->label('Pelaku')
                            ->placeholder('Sistem'),
                        TextEntry::make('log_name')
                            ->label('Log'),
                    ]),
                Section::make('Perubahan')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        KeyValueEntry::make('old')
                            ->label('Sebelum')
                            ->state(fn (Activity $record): array => self::stringify($record->attribute_changes?->get('old'))),
                        KeyValueEntry::make('attributes')
                            ->label('Sesudah')
                            ->state(fn (Activity $record): array => self::stringify($record->attribute_changes?->get('attributes'))),
                    ]),
            ]);
    }

    /**
     * @param  array<string, mixed>|null  $values
     * @return array<string, string>
     */
    private static function stringify(?array $values): array
    {
        return collect($values ?? [])
            ->map(fn (mixed $value): string => is_scalar($value) || $value === null
                ? (string) ($value ?? '')
                : (string) json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES))
            ->all();
    }
}
