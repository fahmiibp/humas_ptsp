<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class WartaMediaController extends Controller
{
    /**
     * Menampilkan gambar dokumentasi Warta melalui endpoint terproteksi.
     *
     * File tidak diakses langsung melalui:
     *
     * /storage/Cover_Foto/...
     *
     * tetapi melalui:
     *
     * /media/warta/{filename}
     */
    public function show(string $filename): BinaryFileResponse
    {
        /*
        |--------------------------------------------------------------------------
        | 1. Sanitasi nama file
        |--------------------------------------------------------------------------
        |
        | Hanya izinkan nama file sederhana.
        | Ini mencegah path traversal seperti:
        |
        | ../.env
        | ../../storage/...
        |
        */

        $filename = basename($filename);

        if (! preg_match('/^[A-Za-z0-9._-]+$/', $filename)) {
            abort(404);
        }

        /*
        |--------------------------------------------------------------------------
        | 2. Lokasi file
        |--------------------------------------------------------------------------
        */

        $path = 'Cover_Foto/' . $filename;

        /*
        |--------------------------------------------------------------------------
        | 3. Cari di private storage terlebih dahulu
        |--------------------------------------------------------------------------
        |
        | Untuk file yang nantinya disimpan menggunakan:
        |
        | ->disk('local')
        |
        */

        $localDisk = Storage::disk('local');

        if ($localDisk->exists($path)) {
            return $this->serveImage(
                $localDisk->path($path),
                $filename
            );
        }

        /*
        |--------------------------------------------------------------------------
        | 4. Fallback ke public storage
        |--------------------------------------------------------------------------
        |
        | Ini diperlukan karena file Warta lama kamu masih berada di:
        |
        | storage/app/public/Cover_Foto/
        |
        | Setelah semua file lama dipindahkan ke private storage,
        | bagian ini bisa dihapus.
        |
        */

        $publicDisk = Storage::disk('public');

        if ($publicDisk->exists($path)) {
            return $this->serveImage(
                $publicDisk->path($path),
                $filename
            );
        }

        /*
        |--------------------------------------------------------------------------
        | 5. File tidak ditemukan
        |--------------------------------------------------------------------------
        */

        abort(404);
    }

    /**
     * Mengirim file gambar ke browser.
     */
    private function serveImage(
        string $fullPath,
        string $filename
    ): BinaryFileResponse {
        /*
        |--------------------------------------------------------------------------
        | Pastikan file benar-benar ada
        |--------------------------------------------------------------------------
        */

        if (! is_file($fullPath)) {
            abort(404);
        }

        /*
        |--------------------------------------------------------------------------
        | Deteksi MIME berdasarkan isi file
        |--------------------------------------------------------------------------
        |
        | Jangan hanya percaya ekstensi .jpg/.png.
        | Ini membantu mencegah file non-gambar disajikan sebagai gambar.
        |
        */

        $mimeType = mime_content_type($fullPath);

        $allowedMimeTypes = [
            'image/jpeg',
            'image/png',
            'image/webp',
        ];

        /*
        |--------------------------------------------------------------------------
        | Tolak file selain gambar
        |--------------------------------------------------------------------------
        */

        if (! in_array($mimeType, $allowedMimeTypes, true)) {
            abort(403);
        }

        /*
        |--------------------------------------------------------------------------
        | Kirim file ke browser
        |--------------------------------------------------------------------------
        */

        return response()->file($fullPath, [
            'Content-Type' => $mimeType,

            /*
             * Jangan izinkan browser melakukan MIME sniffing.
             */
            'X-Content-Type-Options' => 'nosniff',

            /*
             * Tampilkan sebagai gambar di browser.
             */
            'Content-Disposition' => 'inline; filename="' . $filename . '"',

            /*
             * Cache browser selama 1 hari.
             */
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }
}