<?php

namespace App\View\Composers;

use App\Models\MenuItem;
use App\Models\Post;
use App\Settings\GeneralSettings;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PublicLayoutComposer
{
    public function __construct(private GeneralSettings $settings) {}

    public function compose(View $view): void
    {
        $view->with([
            'settings' => $this->settings,
            'logoUrl' => $this->settings->logo ? Storage::disk('public')->url($this->settings->logo) : null,
            'navigation' => $this->navigation(),
            'tickerPosts' => Post::query()->published()->latest('published_at')->take(5)->get(['title', 'slug']),
            'socialLinks' => array_filter([
                'facebook' => $this->settings->facebook,
                'instagram' => $this->settings->instagram,
                'youtube' => $this->settings->youtube,
                'tiktok' => $this->settings->tiktok,
            ]),
        ]);
    }

    /**
     * Menu dari admin, atau menu bawaan saat admin belum menyusun menu.
     *
     * @return array<int, array{label: string, url: string, newTab: bool, children: array<int, array{label: string, url: string, newTab: bool}>}>
     */
    private function navigation(): array
    {
        $menuItems = MenuItem::tree();

        if ($menuItems->isEmpty()) {
            return collect([
                'Beranda' => route('home'),
                'Berita' => route('posts.index'),
                'Galeri' => route('albums.index'),
                'Guru & Pegawai' => route('staff.index'),
                'PKKM' => route('pkkm.index'),
                'Kontak' => route('contact'),
            ])->map(fn (string $url, string $label): array => [
                'label' => $label,
                'url' => $url,
                'newTab' => false,
                'children' => [],
            ])->values()->all();
        }

        return $menuItems->map(fn (MenuItem $item): array => [
            'label' => $item->label,
            'url' => $item->url(),
            'newTab' => $item->open_in_new_tab,
            'children' => $item->children->map(fn (MenuItem $child): array => [
                'label' => $child->label,
                'url' => $child->url(),
                'newTab' => $child->open_in_new_tab,
            ])->all(),
        ])->all();
    }
}
