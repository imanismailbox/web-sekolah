<?php

namespace App\Http\Controllers;

use App\Enums\StaffType;
use App\Models\Staff;
use Illuminate\Contracts\View\View;

class StaffController extends Controller
{
    public function __invoke(): View
    {
        return view('public.staff.index', [
            'teachers' => Staff::query()->active()->where('type', StaffType::Teacher)->get(),
            'employees' => Staff::query()->active()->where('type', StaffType::Employee)->get(),
            'description' => 'Daftar guru dan pegawai madrasah.',
        ]);
    }
}
