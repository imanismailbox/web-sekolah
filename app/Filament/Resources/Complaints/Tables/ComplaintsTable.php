<?php

namespace App\Filament\Resources\Complaints\Tables;

use App\Models\Complaint;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ComplaintsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('read_at')
                    ->label('Status')
                    ->badge()
                    ->state(fn (Complaint $record): string => $record->isRead() ? 'Dibaca' : 'Belum Dibaca')
                    ->color(fn (Complaint $record): string => $record->isRead() ? 'success' : 'warning')
                    ->sortable(),
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('contact')
                    ->label('Email / No. HP')
                    ->placeholder('-')
                    ->searchable(),
                TextColumn::make('message')
                    ->label('Isi Aduan')
                    ->limit(80)
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Dikirim')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                TernaryFilter::make('read_at')
                    ->label('Status')
                    ->nullable()
                    ->trueLabel('Sudah dibaca')
                    ->falseLabel('Belum dibaca')
                    ->placeholder('Semua'),
            ])
            ->recordActions([
                ViewAction::make(),
                Action::make('toggleRead')
                    ->label(fn (Complaint $record): string => $record->isRead() ? 'Belum Dibaca' : 'Tandai Dibaca')
                    ->icon(fn (Complaint $record): Heroicon => $record->isRead()
                        ? Heroicon::OutlinedEnvelope
                        : Heroicon::OutlinedEnvelopeOpen)
                    ->color('gray')
                    ->authorize('update')
                    ->action(function (Complaint $record): void {
                        if ($record->isRead()) {
                            $record->markAsUnread();
                        } else {
                            $record->markAsRead();
                        }
                    }),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
