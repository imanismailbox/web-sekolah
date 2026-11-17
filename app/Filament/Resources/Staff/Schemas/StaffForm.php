<?php

namespace App\Filament\Resources\Staff\Schemas;

use App\Enums\StaffType;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class StaffForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('nip'),
                TextInput::make('nuptk'),
                Select::make('type')
                    ->options(StaffType::class)
                    ->default('guru')
                    ->required(),
                TextInput::make('position'),
                TextInput::make('subject'),
                TextInput::make('photo'),
                TextInput::make('education'),
                TextInput::make('email')
                    ->label('Email address')
                    ->email(),
                TextInput::make('phone')
                    ->tel(),
                TextInput::make('sort')
                    ->required()
                    ->numeric()
                    ->default(0),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
