<?php

namespace App\Http\Controllers;

use App\Enums\EvidenceType;
use App\Models\PkkmEvidence;
use App\Models\PkkmYear;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

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

    public function evidence(string $slug, PkkmEvidence $evidence): StreamedResponse
    {
        $belongsToPublishedYear = PkkmYear::query()
            ->published()
            ->where('slug', $slug)
            ->whereHas('components.items.indicators.evidence', fn ($query) => $query->whereKey($evidence->getKey()))
            ->exists();

        abort_unless($belongsToPublishedYear, 404);
        abort_unless($evidence->type === EvidenceType::File && filled($evidence->file_path), 404);
        abort_unless(Storage::disk('public')->exists($evidence->file_path), 404);

        $filename = Str::slug($evidence->label ?: 'bukti-pkkm').'.pdf';

        return Storage::disk('public')->response(
            $evidence->file_path,
            $filename,
            ['Content-Type' => 'application/pdf'],
            'inline',
        );
    }
}
