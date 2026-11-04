<?php

namespace App\Livewire\Articles;

use App\Ai\Agents\TanyaBerita as TanyaBeritaAgent;
use App\Models\Warta;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Livewire\Component;

class TanyaBerita extends Component
{
    public string $pertanyaan = '';
    public ?string $jawaban = null;
    public array $sumber = [];
    public ?string $error = null;

    public function tanya(): void
    {
        $this->reset('jawaban', 'sumber', 'error');
        $this->pertanyaan = trim(mb_substr($this->pertanyaan, 0, 300));

        if (mb_strlen($this->pertanyaan) < 5) {
            $this->error = 'Tulis pertanyaan minimal 5 karakter.';
            return;
        }

        // 5 pertanyaan per menit per pengunjung (berbasis IP)
        $key = 'tanya-berita:' . request()->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $this->error = 'Terlalu banyak pertanyaan. Coba lagi sebentar.';
            return;
        }
        RateLimiter::hit($key, 60);

        $berita = Warta::query()
            ->where('status_naskah', 'Sudah Tayang')
            ->whereNotNull('jadwal_tayang')
            ->whereDate('jadwal_tayang', '<=', now()->toDateString())
            ->whereFullText(['judul_siaran_pers', 'lead_berita', 'badan_berita'], $this->pertanyaan)
            ->limit(5)
            ->get(['id', 'judul_siaran_pers', 'slug_url', 'lead_berita', 'badan_berita', 'jadwal_tayang']);

        if ($berita->isEmpty()) {
            $this->jawaban = 'Belum ditemukan berita yang berkaitan dengan pertanyaan Anda.';
            return;
        }

        $konteks = $berita->values()->map(fn($w, $i) => sprintf(
            "[%d] %s (%s)\n%s",
            $i + 1,
            $w->judul_siaran_pers,
            $w->jadwal_tayang?->translatedFormat('j F Y'),
            Str::limit(strip_tags((string) $w->badan_berita), 1500)
        ))->implode("\n\n");

        try {
            $hasil = (new TanyaBeritaAgent)->prompt(
                "Pertanyaan: {$this->pertanyaan}\n\nBerita:\n{$konteks}"
            );

            $this->jawaban = (string) ($hasil['jawaban'] ?? '');

            // Hanya terima nomor sumber yang benar-benar ada
            $this->sumber = collect($hasil['sumber'] ?? [])
                ->map(fn($n) => $berita->values()->get((int) $n - 1))
                ->filter()
                ->unique('id')
                ->map(fn($w) => [
                    'judul' => $w->judul_siaran_pers,
                    'url' => route('articles.show', $w->slug_url),
                ])
                ->values()
                ->all();
        } catch (\Throwable $e) {
            report($e);
            $this->error = 'Layanan tanya berita sedang tidak tersedia.';
        }
    }

    public function render()
    {
        return view('livewire.tanya-berita');
    }
}
