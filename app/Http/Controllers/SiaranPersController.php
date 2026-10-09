<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SiaranPersController extends Controller
{
    public function create()
    {
        // Menggunakan helper function inertia()
        return inertia('SiaranPers/CreateSiaranPers');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required',
            'tanggal_publish' => 'required|date',
            'konten' => 'required',
        ]);

        return redirect()->back()->with('message', 'Siaran pers berhasil disimpan!');
    }
}