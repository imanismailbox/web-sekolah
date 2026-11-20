<?php

namespace App\Filament\Resources\PkkmYears\RelationManagers;

use App\Enums\EvidenceType;
use App\Models\PkkmComponent;
use App\Models\PkkmEvidence;
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
use Illuminate\Database\Eloquent\Builder;
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
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->with('items.indicators.evidence'))
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
                TextColumn::make('evidence_progress')
                    ->label('Bukti Terisi')
                    ->badge()
                    ->state(function (PkkmComponent $record): string {
                        $evidence = $record->items->flatMap->indicators->flatMap->evidence;
                        $filled = $evidence->filter(fn (PkkmEvidence $item): bool => $item->isFilled())->count();

                        return "{$filled} / {$evidence->count()}";
                    })
                    ->color(function (PkkmComponent $record): string {
                        $evidence = $record->items->flatMap->indicators->flatMap->evidence;
                        $total = $evidence->count();
                        $filled = $evidence->filter(fn (PkkmEvidence $item): bool => $item->isFilled())->count();

                        if ($total === 0 || $filled === 0) {
                            return 'gray';
                        }

                        return $filled === $total ? 'success' : 'warning';
                    }),
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
            ->label('Rincian Bukti Dukung')
            ->relationship()
            ->orderColumn('sort')
            ->collapsible()
            ->collapsed()
            ->addActionLabel('Tambah Bukti')
            ->itemLabel(function (array $state): string {
                $filled = filled($state['url'] ?? null) || filled($state['file_path'] ?? null);
                $prefix = $filled ? '✓' : '○';

                return trim($prefix.' '.($state['label'] ?? 'Bukti Dukung'));
            })
            ->defaultItems(0)
            ->grid(2)
            ->schema([
                TextInput::make('label')
                    ->label('Rincian Bukti')
                    ->placeholder('Nama berkas / bukti dukung')
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
                    ->placeholder('Kosongkan jika belum diunggah')
                    ->url()
                    ->maxLength(2048)
                    ->visible($isType(EvidenceType::Link)),
                FileUpload::make('file_path')
                    ->label('Berkas')
                    ->disk('public')
                    ->directory(fn (RelationManager $livewire): string => 'pkkm/'.self::yearOf($livewire))
                    ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                    ->maxSize(10240)
                    ->openable()
                    ->downloadable()
                    ->visible($isType(EvidenceType::File)),
            ]);
    }

    private static function yearOf(RelationManager $livewire): int
    {
        /** @var PkkmYear $year */
        $year = $livewire->getOwnerRecord();

        return $year->year;
    }
}
