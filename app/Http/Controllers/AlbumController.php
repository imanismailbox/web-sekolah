<?php

namespace App\Http\Controllers;

use App\Models\Album;
use Illuminate\Contracts\View\View;

class AlbumController extends Controller
{
    public function index(): View
    {
        return view('public.albums.index', [
            'albums' => Album::query()->published()->withCount('photos')->latest('event_date')->paginate(12),
            'description' => 'Galeri kegiatan madrasah.',
        ]);
    }

    public function show(string $slug): View
    {
        $album = Album::query()
            ->published()
            ->with('photos')
            ->where('slug', $slug)
            ->firstOrFail();

        return view('public.albums.show', [
            'album' => $album,
            'description' => $album->description,
        ]);
    }
}
