<?php

namespace App\Filament\Resources\Pages\Schemas;

use App\Filament\Support\SlugFields;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make()
                    ->schema([
                        ...SlugFields::make(),
                        RichEditor::make('content')
                            ->label('Konten')
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsDirectory('pages/attachments'),
                    ])
                    ->columnSpan(['lg' => 2]),
                Group::make([
                    Section::make('Publikasi')
                        ->schema([
                            Toggle::make('is_published')
                                ->label('Terbitkan')
                                ->default(true),
                        ]),
                    Section::make('Gambar Utama')
                        ->schema([
                            FileUpload::make('featured_image')
                                ->hiddenLabel()
                                ->image()
                                ->disk('public')
                                ->directory('pages'),
                        ]),
                ])->columnSpan(['lg' => 1]),
            ]);
    }
}
