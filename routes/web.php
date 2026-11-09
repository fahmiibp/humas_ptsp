<?php

use App\Models\KontenMedsos;
use App\Http\Controllers\SiaranPersController;
use Illuminate\Support\Facades\Route;
use App\Livewire\Articles\Index;
use App\Livewire\Faq\Index as FaqIndex;
use App\Livewire\Articles\Show;

// =========================
// FRONTEND
// =========================

Route::get('/', Index::class)->name('home');

// FAQ frontend
Route::get('/faq', FaqIndex::class)->name('faq');

// Detail artikel / warta
Route::get('/{slug}', Show::class)->name('articles.show');


// =========================
// ADMIN / KONTEN MEDSOS
// =========================

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

Route::get('/siaran-pers/create', [
    SiaranPersController::class,
    'create',
])->name('siaran-pers.create');

Route::post('/siaran-pers', [
    SiaranPersController::class,
    'store',
])->name('siaran-pers.store');
