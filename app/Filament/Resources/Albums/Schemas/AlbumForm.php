<?php

namespace App\Filament\Resources\Albums\Schemas;

use App\Filament\Support\SlugFields;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AlbumForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make()
                    ->schema([
                        ...SlugFields::make(),
                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->rows(4),
                    ])
                    ->columnSpan(['lg' => 2]),
                Group::make([
                    Section::make()
                        ->schema([
                            DatePicker::make('event_date')
                                ->label('Tanggal Kegiatan'),
                            Toggle::make('is_published')
                                ->label('Terbitkan')
                                ->default(true),
                        ]),
                    Section::make('Sampul')
                        ->schema([
                            FileUpload::make('cover')
                                ->hiddenLabel()
                                ->image()
                                ->disk('public')
                                ->directory('albums/covers'),
                        ]),
                ])->columnSpan(['lg' => 1]),
            ]);
    }
}
