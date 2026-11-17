<?php

namespace App\Filament\Resources\PkkmYears\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class PkkmYearForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns(3)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('year')
                            ->label('Tahun')
                            ->required()
                            ->integer()
                            ->minValue(2000)
                            ->maxValue(2100)
                            ->default(now()->year)
                            ->unique(ignoreRecord: true)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Set $set, ?string $state, string $operation): void {
                                if ($operation !== 'create' || blank($state)) {
                                    return;
                                }

                                $set('title', "Penilaian Kinerja Kepala Madrasah (PKKM) Tahun {$state}");
                                $set('slug', "pkkm-tahun-{$state}");
                            }),
                        TextInput::make('title')
                            ->label('Judul')
                            ->required()
                            ->maxLength(255)
                            ->default('Penilaian Kinerja Kepala Madrasah (PKKM) Tahun '.now()->year)
                            ->columnSpan(2),
                        TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->alphaDash()
                            ->default('pkkm-tahun-'.now()->year)
                            ->unique(ignoreRecord: true),
                        Toggle::make('is_published')
                            ->label('Tampilkan di website')
                            ->inline(false),
                        Textarea::make('description')
                            ->label('Keterangan')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
