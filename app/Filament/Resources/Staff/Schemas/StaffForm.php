<?php

namespace App\Filament\Resources\Staff\Schemas;

use App\Enums\StaffType;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class StaffForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make('Data Diri')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Lengkap (dengan gelar)')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        ToggleButtons::make('type')
                            ->label('Jenis')
                            ->options(StaffType::class)
                            ->default(StaffType::Teacher)
                            ->inline()
                            ->live()
                            ->required(),
                        TextInput::make('position')
                            ->label('Jabatan')
                            ->maxLength(255),
                        TextInput::make('subject')
                            ->label('Mata Pelajaran')
                            ->maxLength(255)
                            ->visible(fn (Get $get): bool => $get('type') === StaffType::Teacher || $get('type') === StaffType::Teacher->value),
                        TextInput::make('education')
                            ->label('Pendidikan Terakhir')
                            ->maxLength(255),
                        TextInput::make('nip')
                            ->label('NIP')
                            ->maxLength(30),
                        TextInput::make('nuptk')
                            ->label('NUPTK')
                            ->maxLength(30),
                        TextInput::make('email')
                            ->label('Email')
                            ->email(),
                        TextInput::make('phone')
                            ->label('Telepon')
                            ->tel(),
                    ])
                    ->columnSpan(['lg' => 2]),
                Group::make([
                    Section::make('Foto')
                        ->schema([
                            FileUpload::make('photo')
                                ->hiddenLabel()
                                ->image()
                                ->avatar()
                                ->imageEditor()
                                ->disk('public')
                                ->directory('staff'),
                        ]),
                    Section::make()
                        ->schema([
                            Toggle::make('is_active')
                                ->label('Aktif')
                                ->default(true),
                        ]),
                ])->columnSpan(['lg' => 1]),
            ]);
    }
}
