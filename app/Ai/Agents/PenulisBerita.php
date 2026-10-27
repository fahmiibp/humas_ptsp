<?php

namespace App\Ai\Agents;

use Laravel\Ai\Attributes\Model;
use Laravel\Ai\Attributes\Provider;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Promptable;

#[Provider('gemini')]
#[Model('gemini-3.5-flash-lite')]

class PenulisBerita implements Agent
{
    use Promptable;

    public function instructions(): string
    {
        return <<<'TEXT'
    Kamu adalah asisten penulis berita untuk instansi pemerintah.

    Aturan:
    - Gunakan bahasa Indonesia baku (PUEBI), gaya jurnalistik formal.
    - Pertahankan fakta dari bahan sumber; jangan mengarang nama, jabatan,
      tanggal, lokasi, angka, kutipan, atau dampak.
    - Hindari bahasa promosi, opini, dan sensasionalisme.
    - Jika informasi terbatas, tulis ringkas sesuai fakta yang ada.
    - Keluarkan hanya hasil yang diminta, tanpa pengantar, komentar,
      markdown, atau tanda kutip pembungkus.
    TEXT;
    }
}
