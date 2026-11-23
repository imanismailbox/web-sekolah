<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\ComplaintController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PkkmController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\StaffController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/berita', [PostController::class, 'index'])->name('posts.index');
Route::get('/berita/kategori/{slug}', [PostController::class, 'category'])->name('posts.category');
Route::get('/berita/{slug}', [PostController::class, 'show'])->name('posts.show');

Route::get('/galeri', [AlbumController::class, 'index'])->name('albums.index');
Route::get('/galeri/{slug}', [AlbumController::class, 'show'])->name('albums.show');

Route::get('/guru', StaffController::class)->name('staff.index');

Route::get('/pkkm', [PkkmController::class, 'index'])->name('pkkm.index');
Route::get('/pkkm/{slug}', [PkkmController::class, 'show'])->name('pkkm.show');
Route::get('/pkkm/{slug}/bukti/{evidence}', [PkkmController::class, 'evidence'])->name('pkkm.evidence');

Route::view('/kontak', 'public.contact')->name('contact');

Route::get('/aduan', [ComplaintController::class, 'create'])->name('complaints.create');
Route::post('/aduan', [ComplaintController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('complaints.store');

Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');

// Harus paling akhir: menangkap halaman statis berdasarkan slug.
Route::get('/{slug}', [PageController::class, 'show'])
    ->where('slug', '[a-z0-9-]+')
    ->name('pages.show');
