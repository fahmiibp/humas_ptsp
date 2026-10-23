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
#[Temperature(0.2)]
class PenulisKegiatan implements Agent
{
    use Promptable;

    public function instructions(): string
    {
        return 'Kamu bertugas merapikan nama kegiatan untuk arsip dokumentasi instansi pemerintah. '
            . 'Gunakan format penamaan kegiatan yang baku, formal, ringkas, dan konsisten. '
            . 'Perbaiki ejaan, kapitalisasi, dan tata bahasa Indonesia. '
            . 'Gunakan nama resmi acara atau singkatan resmi jika tersedia. '
            . 'Pertahankan nama acara, tema, sesi, dan tahun yang tercantum dalam input. '
            . 'Sertakan lokasi singkat hanya jika lokasi diberikan secara eksplisit. '
            . 'Gunakan tanda pisah (–) untuk memisahkan nama acara dan keterangan sesi atau lokasi jika sesuai. '
            . 'Jangan mengarang nama acara, lokasi, tanggal, tahun, jabatan, atau informasi lainnya. '
            . 'Jangan mengubah singkatan yang tidak diketahui maknanya. '
            . 'Pertahankan istilah asing resmi seperti "Pitching Session" jika relevan. '
            . 'Gunakan maksimal 12 kata jika memungkinkan tanpa menghilangkan informasi penting. '
            . 'Jawab hanya dengan satu nama kegiatan dalam satu baris, tanpa markdown, tanda kutip, atau penjelasan.';
    }
}
