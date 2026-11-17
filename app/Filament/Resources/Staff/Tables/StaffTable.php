<?php

namespace App\Filament\Resources\Staff\Tables;

use App\Enums\StaffType;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class StaffTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->reorderable('sort')
            ->defaultSort('sort')
            ->columns([
                ImageColumn::make('photo')
                    ->label('Foto')
                    ->disk('public')
                    ->circular(),
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->description(fn ($record): ?string => $record->nip ? "NIP {$record->nip}" : null),
                TextColumn::make('type')
                    ->label('Jenis')
                    ->badge(),
                TextColumn::make('position')
                    ->label('Jabatan')
                    ->searchable(),
                TextColumn::make('subject')
                    ->label('Mapel')
                    ->placeholder('-')
                    ->toggleable(),
                ToggleColumn::make('is_active')
                    ->label('Aktif'),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Jenis')
                    ->options(StaffType::class),
                TernaryFilter::make('is_active')
                    ->label('Aktif'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
