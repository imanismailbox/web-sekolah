<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreComplaintRequest;
use App\Models\Complaint;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ComplaintController extends Controller
{
    public function create(): View
    {
        return view('public.complaints.create');
    }

    public function store(StoreComplaintRequest $request): RedirectResponse
    {
        Complaint::query()->create(
            $request->safe()->only(['name', 'contact', 'message']),
        );

        return redirect()
            ->route('complaints.create')
            ->with('status', 'Terima kasih, aduan atau kritik dan saran Anda telah terkirim.');
    }
}
