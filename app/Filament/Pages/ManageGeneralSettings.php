<?php

namespace App\Filament\Pages;

use App\Settings\GeneralSettings;
use BackedEnum;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Pages\SettingsPage;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ManageGeneralSettings extends SettingsPage
{
    use HasPageShield;

    protected static string $settings = GeneralSettings::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string|UnitEnum|null $navigationGroup = 'Sistem';

    protected static ?string $navigationLabel = 'Pengaturan';

    protected static ?string $title = 'Pengaturan Situs';

    protected static ?int $navigationSort = 1;

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make()
                    ->columnSpanFull()
                    ->tabs([
                        Tab::make('Umum')
                            ->icon(Heroicon::OutlinedHome)
                            ->schema([
                                TextInput::make('site_name')
                                    ->label('Nama Sekolah')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('tagline')
                                    ->label('Tagline')
                                    ->maxLength(255),
                                Grid::make(2)->schema([
                                    FileUpload::make('logo')
                                        ->label('Logo')
                                        ->image()
                                        ->disk('public')
                                        ->directory('settings'),
                                    FileUpload::make('favicon')
                                        ->label('Favicon')
                                        ->image()
                                        ->disk('public')
                                        ->directory('settings'),
                                ]),
                                Textarea::make('footer_text')
                                    ->label('Teks Footer')
                                    ->rows(2),
                            ]),
                        Tab::make('Kontak')
                            ->icon(Heroicon::OutlinedPhone)
                            ->schema([
                                Textarea::make('address')
                                    ->label('Alamat')
                                    ->rows(3),
                                Grid::make(3)->schema([
                                    TextInput::make('phone')->label('Telepon')->tel(),
                                    TextInput::make('whatsapp')->label('WhatsApp')->tel(),
                                    TextInput::make('email')->label('Email')->email(),
                                ]),
                                Textarea::make('maps_embed')
                                    ->label('Embed Google Maps (iframe)')
                                    ->rows(3),
                            ]),
                        Tab::make('Media Sosial')
                            ->icon(Heroicon::OutlinedShare)
                            ->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('facebook')->label('Facebook')->url(),
                                    TextInput::make('instagram')->label('Instagram')->url(),
                                    TextInput::make('youtube')->label('YouTube')->url(),
                                    TextInput::make('tiktok')->label('TikTok')->url(),
                                ]),
                            ]),
                        Tab::make('Kepala Madrasah')
                            ->icon(Heroicon::OutlinedUserCircle)
                            ->schema([
                                TextInput::make('headmaster_name')
                                    ->label('Nama Kepala Madrasah'),
                                FileUpload::make('headmaster_photo')
                                    ->label('Foto')
                                    ->image()
                                    ->disk('public')
                                    ->directory('settings'),
                                RichEditor::make('headmaster_greeting')
                                    ->label('Sambutan'),
                            ]),
                        Tab::make('Musik Latar')
                            ->icon(Heroicon::OutlinedMusicalNote)
                            ->schema([
                                Toggle::make('background_music_enabled')
                                    ->label('Putar musik latar di situs')
                                    ->helperText('Musik diputar otomatis saat halaman dibuka. Jika browser memblokir pemutaran otomatis, musik akan mulai saat pengunjung pertama kali berinteraksi dengan halaman.'),
                                FileUpload::make('background_music')
                                    ->label('File Musik (MP3/OGG)')
                                    ->acceptedFileTypes(['audio/mpeg', 'audio/ogg', 'audio/mp4', 'audio/wav'])
                                    ->maxSize(20480)
                                    ->disk('public')
                                    ->directory('settings')
                                    ->helperText('Maksimal 20 MB. Musik akan diulang (loop) selama halaman terbuka.'),
                            ]),
                    ]),
            ]);
    }
}
