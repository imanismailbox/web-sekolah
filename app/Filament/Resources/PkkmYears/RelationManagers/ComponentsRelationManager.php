<?php

namespace App\Filament\Resources\PkkmYears\RelationManagers;

use App\Enums\EvidenceType;
use App\Models\PkkmYear;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Width;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

/**
 * Manages the PKKM instrument tree of a year:
 * Komponen → Unsur/Tugas Utama → Indikator → Bukti Dukung.
 */
class ComponentsRelationManager extends RelationManager
{
    protected static string $relationship = 'components';

    protected static ?string $title = 'Komponen & Bukti Dukung';

    protected static ?string $modelLabel = 'Komponen';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(6)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('code')
                            ->label('Kode')
                            ->placeholder('A')
                            ->required()
                            ->maxLength(10),
                        TextInput::make('name')
                            ->label('Nama Komponen')
                            ->placeholder('Usaha Pengembangan Madrasah')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(5),
                    ]),
                Repeater::make('items')
                    ->label('Unsur / Tugas Utama')
                    ->relationship()
                    ->orderColumn('sort')
                    ->collapsible()
                    ->collapsed()
                    ->cloneable()
                    ->addActionLabel('Tambah Unsur')
                    ->itemLabel(fn (array $state): string => trim(($state['code'] ?? '').' '.Str::limit($state['name'] ?? '', 90)))
                    ->columnSpanFull()
                    ->schema([
                        Grid::make(6)->schema([
                            TextInput::make('code')
                                ->label('No.')
                                ->placeholder('1.1')
                                ->required()
                                ->maxLength(20),
                            Textarea::make('name')
                                ->label('Unsur / Tugas Utama')
                                ->required()
                                ->rows(2)
                                ->columnSpan(5),
                        ]),
                        Repeater::make('indicators')
                            ->label('Indikator Kinerja')
                            ->relationship()
                            ->orderColumn('sort')
                            ->collapsible()
                            ->addActionLabel('Tambah Indikator')
                            ->itemLabel(fn (array $state): string => trim(($state['number'] ?? '').'. '.Str::limit($state['description'] ?? '', 90), '. '))
                            ->schema([
                                Grid::make(6)->schema([
                                    TextInput::make('number')
                                        ->label('No.')
                                        ->maxLength(10),
                                    Textarea::make('description')
                                        ->label('Indikator Kinerja')
                                        ->required()
                                        ->rows(2)
                                        ->columnSpan(5),
                                ]),
                                Textarea::make('expected_evidence')
                                    ->label('Data / Bukti Fisik yang Diharapkan')
                                    ->rows(2),
                                self::evidenceRepeater(),
                            ]),
                    ]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->reorderable('sort')
            ->defaultSort('sort')
            ->columns([
                TextColumn::make('code')
                    ->label('Kode'),
                TextColumn::make('name')
                    ->label('Komponen')
                    ->wrap(),
                TextColumn::make('items_count')
                    ->label('Unsur')
                    ->counts('items'),
            ])
            ->headerActions([
                CreateAction::make()
                    ->slideOver()
                    ->modalWidth(Width::SevenExtraLarge),
            ])
            ->recordActions([
                EditAction::make()
                    ->label('Kelola')
                    ->slideOver()
                    ->modalWidth(Width::SevenExtraLarge),
                DeleteAction::make(),
            ]);
    }

    private static function evidenceRepeater(): Repeater
    {
        $isType = fn (EvidenceType $type): \Closure => fn (Get $get): bool => EvidenceType::tryFrom(
            $get('type') instanceof EvidenceType ? $get('type')->value : (string) $get('type')
        ) === $type;

        return Repeater::make('evidence')
            ->label('Bukti Dukung')
            ->relationship()
            ->orderColumn('sort')
            ->addActionLabel('Tambah Bukti')
            ->defaultItems(0)
            ->grid(2)
            ->schema([
                TextInput::make('label')
                    ->label('Label')
                    ->placeholder('Lihat')
                    ->default('Lihat')
                    ->maxLength(255),
                ToggleButtons::make('type')
                    ->label('Jenis')
                    ->options(EvidenceType::class)
                    ->default(EvidenceType::Link)
                    ->inline()
                    ->live()
                    ->required(),
                TextInput::make('url')
                    ->label('URL (Google Drive, dll.)')
                    ->url()
                    ->maxLength(2048)
                    ->visible($isType(EvidenceType::Link))
                    ->required($isType(EvidenceType::Link)),
                FileUpload::make('file_path')
                    ->label('Berkas')
                    ->disk('public')
                    ->directory(fn (RelationManager $livewire): string => 'pkkm/'.self::yearOf($livewire))
                    ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                    ->maxSize(10240)
                    ->openable()
                    ->downloadable()
                    ->visible($isType(EvidenceType::File))
                    ->required($isType(EvidenceType::File)),
            ]);
    }

    private static function yearOf(RelationManager $livewire): int
    {
        /** @var PkkmYear $year */
        $year = $livewire->getOwnerRecord();

        return $year->year;
    }
}
