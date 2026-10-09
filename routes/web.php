<?php

use App\Models\KontenMedsos;
use App\Http\Controllers\SiaranPersController;
use Illuminate\Support\Facades\Route;

// Rute untuk delete
Route::delete('/admin/konten-medsos/{id}/calendar-delete', function ($id) {
    $konten = KontenMedsos::findOrFail($id);
    $konten->delete();

    return response()->json([
        'success' => true
    ]);
});

// Taruh di LUAR fungsi delete (di paling bawah)
Route::get('/siaran-pers/create', [SiaranPersController::class, 'create'])->name('siaran-pers.create');
Route::post('/siaran-pers', [SiaranPersController::class, 'store'])->name('siaran-pers.store');