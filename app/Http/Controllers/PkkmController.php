<?php

namespace App\Http\Controllers;

use App\Models\PkkmYear;
use Illuminate\Contracts\View\View;

class PkkmController extends Controller
{
    public function index(): View
    {
        return view('public.pkkm.index', [
            'years' => PkkmYear::query()->published()->with('components.items.indicators.evidence')->orderByDesc('year')->get(),
            'description' => 'Penilaian Kinerja Kepala Madrasah (PKKM).',
        ]);
    }

    public function show(string $slug): View
    {
        $pkkmYear = PkkmYear::query()
            ->published()
            ->with('components.items.indicators.evidence')
            ->where('slug', $slug)
            ->firstOrFail();

        return view('public.pkkm.show', [
            'pkkmYear' => $pkkmYear,
            'description' => $pkkmYear->title,
        ]);
    }
}
