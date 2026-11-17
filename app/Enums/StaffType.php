<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum StaffType: string implements HasLabel
{
    case Teacher = 'guru';
    case Employee = 'pegawai';

    public function getLabel(): string
    {
        return match ($this) {
            self::Teacher => 'Guru',
            self::Employee => 'Pegawai',
        };
    }
}
