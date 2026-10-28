<?php

use App\Models\KontenMedsos;
use App\Http\Controllers\SiaranPersController;
use Illuminate\Support\Facades\Route;
use App\Livewire\Articles\{Index, Show};

Route::get('/', Index::class)->name('home');
Route::get('/berita/{slug}', Show::class)->name('articles.show');

Route::delete('/admin/konten-medsos/{id}/calendar-delete', function ($id) {
    $konten = KontenMedsos::findOrFail($id);
    $konten->delete();

    return response()->json([
        'success' => true
    ]);
});

Route::get('/siaran-pers/create', [SiaranPersController::class, 'create'])->name('siaran-pers.create');
Route::post('/siaran-pers', [SiaranPersController::class, 'store'])->name('siaran-pers.store');
