<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\PkkmYear;
use App\Models\Post;
use App\Models\Slide;
use App\Settings\GeneralSettings;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function __invoke(GeneralSettings $settings): View
    {
        $latestPkkmYear = PkkmYear::query()
            ->published()
            ->with('components.items.indicators.evidence')
            ->orderByDesc('year')
            ->first();

        return view('public.home', [
            'settings' => $settings,
            'slides' => Slide::query()->active()->get(),
            'latestPosts' => Post::query()
                ->published()
                ->with('category')
                ->orderByDesc('is_featured')
                ->latest('published_at')
                ->take(4)
                ->get(),
            'latestAlbums' => Album::query()
                ->published()
                ->withCount('photos')
                ->latest('event_date')
                ->take(4)
                ->get(),
            'latestPkkmYear' => $latestPkkmYear,
            'otherPkkmYears' => PkkmYear::query()
                ->published()
                ->when($latestPkkmYear, fn ($query) => $query->whereKeyNot($latestPkkmYear->getKey()))
                ->orderByDesc('year')
                ->take(4)
                ->get(['year', 'slug', 'title']),
        ]);
    }
}
