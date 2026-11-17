<?php

namespace App\Filament\Resources\Albums\RelationManagers;

use App\Models\Album;
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
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PhotosRelationManager extends RelationManager
{
    protected static string $relationship = 'photos';

    protected static ?string $title = 'Foto';

    protected static ?string $modelLabel = 'Foto';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('image')
                    ->label('Foto')
                    ->image()
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
                ImageColumn::make('image')
                    ->label('Foto')
                    ->disk('public')
                    ->imageHeight(80),
                TextColumn::make('caption')
                    ->label('Keterangan')
                    ->placeholder('-'),
            ])
            ->headerActions([
                Action::make('uploadPhotos')
                    ->label('Unggah Foto')
                    ->icon(Heroicon::OutlinedArrowUpTray)
                    ->schema([
                        FileUpload::make('images')
                            ->label('Foto')
                            ->image()
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
                            ->title(count($data['images']).' foto berhasil diunggah')
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
