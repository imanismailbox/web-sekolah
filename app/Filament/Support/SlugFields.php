<?php

namespace App\Filament\Support;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Illuminate\Support\Str;

/**
 * Title + slug input pair where the slug follows the title until edited manually.
 */
class SlugFields
{
    /**
     * @return array{0: TextInput, 1: TextInput}
     */
    public static function make(string $titleField = 'title', string $titleLabel = 'Judul', string $slugField = 'slug'): array
    {
        return [
            TextInput::make($titleField)
                ->label($titleLabel)
                ->required()
                ->maxLength(255)
                ->live(onBlur: true)
                ->afterStateUpdated(function (Get $get, Set $set, ?string $old, ?string $state) use ($slugField): void {
                    if (filled($get($slugField)) && $get($slugField) !== Str::slug((string) $old)) {
                        return;
                    }

                    $set($slugField, Str::slug((string) $state));
                }),
            TextInput::make($slugField)
                ->label('Slug')
                ->required()
                ->maxLength(255)
                ->alphaDash()
                ->unique(ignoreRecord: true),
        ];
    }
}
