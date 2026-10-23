<?php

namespace App\Ai\Agents;

use Laravel\Ai\Attributes\MaxTokens;
use Laravel\Ai\Attributes\Model;
use Laravel\Ai\Attributes\Provider;
use Laravel\Ai\Attributes\Temperature;
use Laravel\Ai\Contracts\Agent;
use Laravel\Ai\Promptable;

#[Provider('gemini')]
#[Model('gemini-3.5-flash-lite')]
#[MaxTokens(100)]
#[Temperature(0.3)]
class JudulArsip implements Agent
{
    use Promptable;

    public function instructions(): string
    {
        return 'Kamu bertugas membuat judul arsip dokumentasi kegiatan instansi pemerintah. '
            . 'Buat satu judul arsip yang formal, jelas, ringkas, dan sesuai kaidah bahasa Indonesia. '
            . 'Gunakan pola "Arsip Kegiatan [nama kegiatan]". '
            . 'Pertahankan inti nama kegiatan yang diberikan tanpa mengubah maknanya. '
            . 'Jangan menambahkan informasi, nama, jabatan, lokasi, atau tanggal yang tidak diberikan. '
            . 'Gunakan maksimal 12 kata. '
            . 'Hindari kata yang berulang dan frasa yang tidak diperlukan. '
            . 'Jawab hanya dengan judul arsip dalam satu baris, tanpa penjelasan, markdown, atau tanda kutip.';
    }
}
