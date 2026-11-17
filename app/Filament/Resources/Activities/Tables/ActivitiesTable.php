<?php

namespace App\Filament\Resources\Activities\Tables;

use App\Filament\Resources\Activities\ActivityResource;
use App\Models\User;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Activitylog\Models\Activity;

class ActivitiesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->with('causer'))
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('created_at')
                    ->label('Waktu')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                TextColumn::make('causer.name')
                    ->label('Pelaku')
                    ->placeholder('Sistem'),
                TextColumn::make('event')
                    ->label('Aksi')
                    ->badge()
                    ->color(fn (?string $state): string => match ($state) {
                        'created' => 'success',
                        'updated' => 'warning',
                        'deleted' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('subject_type')
                    ->label('Objek')
                    ->formatStateUsing(fn (?string $state, Activity $record): string => ActivityResource::subjectLabel($state).' #'.$record->subject_id),
                TextColumn::make('description')
                    ->label('Deskripsi')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('event')
                    ->label('Aksi')
                    ->options([
                        'created' => 'created',
                        'updated' => 'updated',
                        'deleted' => 'deleted',
                    ]),
                SelectFilter::make('subject_type')
                    ->label('Objek')
                    ->options(fn (): array => Activity::query()
                        ->whereNotNull('subject_type')
                        ->distinct()
                        ->pluck('subject_type')
                        ->mapWithKeys(fn (string $type): array => [$type => ActivityResource::subjectLabel($type)])
                        ->all()),
                SelectFilter::make('causer_id')
                    ->label('Pelaku')
                    ->options(fn (): array => User::query()->orderBy('name')->pluck('name', 'id')->all())
                    ->query(fn (Builder $query, array $data): Builder => $query->when(
                        $data['value'],
                        fn (Builder $query, string $userId): Builder => $query
                            ->where('causer_type', (new User)->getMorphClass())
                            ->where('causer_id', $userId),
                    )),
            ])
            ->recordActions([
                ViewAction::make(),
            ]);
    }
}
