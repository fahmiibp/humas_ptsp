<?php

use App\Models\KontenMedsos;
use Illuminate\Support\Facades\Route;


Route::delete(
    '/admin/konten-medsos/{id}/calendar-delete',
    function ($id) {

        $konten = KontenMedsos::findOrFail($id);

        $konten->delete();


        return response()->json([
            'success' => true
        ]);

    }
);