<?php

namespace App\Filament\Resources\MenuItems\Schemas;

use App\Enums\MenuItemType;
use App\Models\MenuItem;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class MenuItemForm
{
    public static function configure(Schema $schema, bool $withParent = true): Schema
    {
        $type = fn (Get $get): ?MenuItemType => $get('type') instanceof MenuItemType
            ? $get('type')
            : MenuItemType::tryFrom((string) $get('type'));

        return $schema
            ->columns(2)
            ->components([
                TextInput::make('label')
                    ->label('Label')
                    ->required()
                    ->maxLength(100),
                Select::make('parent_id')
                    ->label('Induk Menu')
                    ->placeholder('— Menu utama —')
                    ->options(fn (?MenuItem $record): array => MenuItem::query()
                        ->whereNull('parent_id')
                        ->when($record, fn ($query) => $query->whereKeyNot($record->getKey()))
                        ->orderBy('sort')
                        ->pluck('label', 'id')
                        ->all())
                    ->disabled(fn (?MenuItem $record): bool => (bool) $record?->children()->exists())
                    ->helperText('Maksimal 2 tingkat. Menu yang memiliki sub-menu tidak dapat dipindah menjadi sub-menu.')
                    ->visible($withParent),
                Select::make('type')
                    ->label('Jenis Tautan')
                    ->options(MenuItemType::class)
                    ->default(MenuItemType::Url)
                    ->helperText('Pilih "Tanpa Tautan" untuk induk yang hanya membuka dropdown sub-menu.')
                    ->required()
                    ->live()
                    ->afterStateUpdated(function (Set $set): void {
                        $set('target_id', null);
                        $set('route_name', null);
                    }),
                TextInput::make('url')
                    ->label('URL')
                    ->placeholder('https://… atau /path')
                    ->required(fn (Get $get): bool => $type($get) === MenuItemType::Url)
                    ->visible(fn (Get $get): bool => $type($get) === MenuItemType::Url)
                    ->maxLength(2048),
                Select::make('route_name')
                    ->label('Halaman Bawaan')
                    ->options(MenuItemType::builtInRoutes())
                    ->required(fn (Get $get): bool => $type($get) === MenuItemType::Route)
                    ->visible(fn (Get $get): bool => $type($get) === MenuItemType::Route),
                Select::make('target_id')
                    ->label('Tujuan')
                    ->options(fn (Get $get): array => $type($get)?->targetOptions() ?? [])
                    ->searchable()
                    ->required(fn (Get $get): bool => $type($get)?->targetModel() !== null)
                    ->visible(fn (Get $get): bool => $type($get)?->targetModel() !== null),
                Toggle::make('open_in_new_tab')
                    ->label('Buka di tab baru'),
                Toggle::make('is_active')
                    ->label('Aktif')
                    ->default(true),
            ]);
    }
}
