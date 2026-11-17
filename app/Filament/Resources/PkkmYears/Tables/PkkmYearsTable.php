<?php

namespace App\Filament\Resources\PkkmYears\Tables;

use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class PkkmYearsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('year', 'desc')
            ->columns([
                TextColumn::make('year')
                    ->label('Tahun')
                    ->sortable(),
                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable(),
                TextColumn::make('components_count')
                    ->label('Komponen')
                    ->counts('components'),
                ToggleColumn::make('is_published')
                    ->label('Tampil'),
                TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->since()
                    ->sortable(),
            ])
            ->recordActions([
                EditAction::make()
                    ->label('Kelola'),
                DeleteAction::make(),
            ]);
    }
}
