<?php

use App\Http\Controllers\SiaranPersController;
use App\Http\Controllers\WartaMediaController;
use App\Livewire\Articles\Index;
use App\Livewire\Articles\Show;
use App\Livewire\Faq\Index as FaqIndex;
use App\Models\KontenMedsos;
use Illuminate\Support\Facades\Route;

// =========================
// FRONTEND
// =========================

// Homepage
Route::get('/', Index::class)->name('home');


// =========================
// FAQ
// =========================

// FAQ frontend
Route::get('/faq', FaqIndex::class)->name('faq');


// =========================
// MEDIA WARTA
// =========================

// Menampilkan gambar Warta melalui Laravel
// File tidak diakses langsung melalui /storage/...
Route::get('/media/warta/{filename}', [WartaMediaController::class, 'show'])
    ->where('filename', '[A-Za-z0-9._-]+')
    ->name('media.warta');


// =========================
// DETAIL ARTIKEL / WARTA
// =========================

// Route wildcard harus diletakkan PALING BAWAH
Route::get('/{slug}', Show::class)
    ->name('articles.show');


// =========================
// ADMIN / KONTEN MEDSOS
// =========================

// Hapus konten medsos dari kalender
Route::delete('/admin/konten-medsos/{id}/calendar-delete', function ($id) {
    $konten = KontenMedsos::findOrFail($id);

    $konten->delete();

    return response()->json([
        'success' => true,
    ]);
});


// =========================
// SIARAN PERS
// =========================

// Form create siaran pers
Route::get('/siaran-pers/create', [
    SiaranPersController::class,
    'create',
])->name('siaran-pers.create');

// Simpan siaran pers
Route::post('/siaran-pers', [
    SiaranPersController::class,
    'store',
])->name('siaran-pers.store');