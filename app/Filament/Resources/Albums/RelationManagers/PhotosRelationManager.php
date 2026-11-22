<?php

namespace App\Filament\Resources\Albums\RelationManagers;

use App\Models\Album;
use App\Models\AlbumPhoto;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ViewColumn;
use Filament\Tables\Table;

class PhotosRelationManager extends RelationManager
{
    protected static string $relationship = 'photos';

    protected static ?string $title = 'Foto & Video';

    protected static ?string $modelLabel = 'Media';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('image')
                    ->label('Foto / Video (MP4)')
                    ->acceptedFileTypes(['image/*', 'video/mp4'])
                    ->maxSize(51200)
                    ->helperText('Format yang didukung: gambar (JPG, PNG, WebP, dll.) atau video MP4 maksimal 50 MB.')
                    ->disk('public')
                    ->directory('albums')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('caption')
                    ->label('Keterangan')
                    ->maxLength(255)
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('caption')
            ->reorderable('sort')
            ->defaultSort('sort')
            ->columns([
                ViewColumn::make('image')
                    ->label('Pratinjau')
                    ->view('filament.tables.columns.album-media-preview'),
                TextColumn::make('media_type')
                    ->label('Jenis')
                    ->badge()
                    ->state(fn (AlbumPhoto $record): string => $record->isVideo() ? 'Video' : 'Foto')
                    ->color(fn (string $state): string => $state === 'Video' ? 'info' : 'gray'),
                TextColumn::make('caption')
                    ->label('Keterangan')
                    ->placeholder('-'),
            ])
            ->headerActions([
                Action::make('uploadPhotos')
                    ->label('Unggah Foto / Video')
                    ->icon(Heroicon::OutlinedArrowUpTray)
                    ->schema([
                        FileUpload::make('images')
                            ->label('Foto / Video (MP4)')
                            ->acceptedFileTypes(['image/*', 'video/mp4'])
                            ->maxSize(51200)
                            ->helperText('Bisa pilih beberapa foto dan/atau video MP4 sekaligus (maksimal 50 MB per berkas).')
                            ->multiple()
                            ->reorderable()
                            ->disk('public')
                            ->directory('albums')
                            ->maxFiles(50)
                            ->required(),
                    ])
                    ->action(function (array $data): void {
                        /** @var Album $album */
                        $album = $this->getOwnerRecord();
                        $sort = (int) $album->photos()->max('sort');

                        foreach ($data['images'] as $image) {
                            $album->photos()->create([
                                'image' => $image,
                                'sort' => ++$sort,
                            ]);
                        }

                        Notification::make()
                            ->title(count($data['images']).' media berhasil diunggah')
                            ->success()
                            ->send();
                    }),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
