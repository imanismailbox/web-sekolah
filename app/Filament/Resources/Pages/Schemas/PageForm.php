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
                    Section::make('Gambar Latar Header')
                        ->description('Kosongkan untuk memakai gambar header dari Pengaturan Situs.')
                        ->schema([
                            FileUpload::make('header_image')
                                ->hiddenLabel()
                                ->image()
                                ->imageEditor()
                                ->imageEditorAspectRatios(['4:1', '16:9'])
                                ->maxSize(4096)
                                ->disk('public')
                                ->directory('pages/headers'),
                        ]),
                ])->columnSpan(['lg' => 1]),
            ]);
    }
}
