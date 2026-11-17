<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Enums\PostStatus;
use App\Filament\Resources\Categories\CategoryResource;
use App\Filament\Support\SlugFields;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieTagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Group::make([
                    Section::make()
                        ->schema([
                            ...SlugFields::make(),
                            Textarea::make('excerpt')
                                ->label('Ringkasan')
                                ->rows(3),
                            RichEditor::make('content')
                                ->label('Isi Berita')
                                ->required()
                                ->fileAttachmentsDisk('public')
                                ->fileAttachmentsDirectory('posts/attachments'),
                        ]),
                ])->columnSpan(['lg' => 2]),
                Group::make([
                    Section::make('Publikasi')
                        ->schema([
                            Select::make('status')
                                ->label('Status')
                                ->options(PostStatus::class)
                                ->default(PostStatus::Draft)
                                ->required(),
                            DateTimePicker::make('published_at')
                                ->label('Tanggal Terbit')
                                ->default(now()),
                            Toggle::make('is_featured')
                                ->label('Berita Unggulan'),
                        ]),
                    Section::make('Klasifikasi')
                        ->schema([
                            Select::make('category_id')
                                ->label('Kategori')
                                ->relationship('category', 'name')
                                ->searchable()
                                ->preload()
                                ->createOptionForm(fn (Schema $schema): Schema => CategoryResource::form($schema)),
                            SpatieTagsInput::make('tags')
                                ->label('Tags')
                                ->type(null),
                        ]),
                    Section::make('Gambar Utama')
                        ->schema([
                            FileUpload::make('thumbnail')
                                ->hiddenLabel()
                                ->image()
                                ->imageEditor()
                                ->disk('public')
                                ->directory('posts'),
                        ]),
                ])->columnSpan(['lg' => 1]),
            ]);
    }
}
