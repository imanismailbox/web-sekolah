<?php

namespace App\Filament\Resources\Complaints\Schemas;

use App\Models\Complaint;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ComplaintInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Pengirim')
                    ->columns(3)
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('name')
                            ->label('Nama'),
                        TextEntry::make('contact')
                            ->label('Email / No. HP')
                            ->placeholder('-'),
                        TextEntry::make('read_at')
                            ->label('Status')
                            ->badge()
                            ->state(fn (Complaint $record): string => $record->isRead() ? 'Dibaca' : 'Belum Dibaca')
                            ->color(fn (Complaint $record): string => $record->isRead() ? 'success' : 'warning'),
                        TextEntry::make('created_at')
                            ->label('Dikirim Pada')
                            ->dateTime('d M Y H:i:s'),
                    ]),
                Section::make('Isi Aduan / Kritik & Saran')
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('message')
                            ->hiddenLabel()
                            ->prose(),
                    ]),
            ]);
    }
}
