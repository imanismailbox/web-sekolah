<?php

namespace App\Enums;

use App\Models\Album;
use App\Models\Category;
use App\Models\Page;
use App\Models\PkkmYear;
use Filament\Support\Contracts\HasLabel;
use Illuminate\Database\Eloquent\Model;

enum MenuItemType: string implements HasLabel
{
    case Url = 'url';
    case Route = 'route';
    case Page = 'page';
    case Category = 'category';
    case Album = 'album';
    case PkkmYear = 'pkkm_year';

    public function getLabel(): string
    {
        return match ($this) {
            self::Url => 'Tautan Kustom',
            self::Route => 'Halaman Bawaan',
            self::Page => 'Halaman',
            self::Category => 'Kategori Berita',
            self::Album => 'Album Galeri',
            self::PkkmYear => 'PKKM Tahun',
        };
    }

    /**
     * Model class referenced by `target_id` for this type, if any.
     *
     * @return class-string<Model>|null
     */
    public function targetModel(): ?string
    {
        return match ($this) {
            self::Page => Page::class,
            self::Category => Category::class,
            self::Album => Album::class,
            self::PkkmYear => PkkmYear::class,
            default => null,
        };
    }

    /**
     * Named route (public site) used to build the URL from the target's slug.
     */
    public function targetRouteName(): ?string
    {
        return match ($this) {
            self::Page => 'pages.show',
            self::Category => 'posts.category',
            self::Album => 'albums.show',
            self::PkkmYear => 'pkkm.show',
            default => null,
        };
    }

    /**
     * Built-in public routes selectable for the "Route" type.
     *
     * @return array<string, string>
     */
    public static function builtInRoutes(): array
    {
        return [
            'home' => 'Beranda',
            'posts.index' => 'Berita',
            'albums.index' => 'Galeri',
            'staff.index' => 'Guru & Pegawai',
            'pkkm.index' => 'PKKM',
        ];
    }
}
