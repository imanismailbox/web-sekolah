<?php

namespace App\Enums;

use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Icons\Heroicon;

enum EvidenceType: string implements HasIcon, HasLabel
{
    case Link = 'link';
    case File = 'file';

    public function getLabel(): string
    {
        return match ($this) {
            self::Link => 'Tautan',
            self::File => 'Unggah Berkas',
        };
    }

    public function getIcon(): Heroicon
    {
        return match ($this) {
            self::Link => Heroicon::OutlinedLink,
            self::File => Heroicon::OutlinedDocumentArrowUp,
        };
    }
}
