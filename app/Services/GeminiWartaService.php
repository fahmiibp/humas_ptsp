<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use RuntimeException;
use Throwable;

class GeminiWartaService
{
    /**
     * Membuat draf berita berdasarkan data dari form Warta.
     *
     * Service ini hanya menghasilkan teks.
     * Tidak menyimpan record dan tidak mengubah status verifikasi.
     */
    public function generateDraft(array $data): string
    {
        $apiKey = config('services.gemini.api_key');

        $model = trim(
            (string) config('services.gemini.model', 'gemini-3.8-flash')
        );

        // Mencegah URL menjadi models/models/...
        $model = preg_replace('#^models/#', '', $model);

        if (blank($apiKey)) {
            throw new RuntimeException(
                'API key Gemini belum dikonfigurasi.'
            );
        }

        if ($model === '') {
            throw new RuntimeException(
                'Model Gemini belum dikonfigurasi.'
            );
        }

        $judul = trim((string) ($data['judul'] ?? ''));
        $lead = trim((string) ($data['lead'] ?? ''));
        $tanggal = trim((string) ($data['tanggal'] ?? ''));

        if ($judul === '') {
            throw new RuntimeException(
                'Judul berita wajib diisi sebelum menggunakan AI.'
            );
        }

        $prompt = <<<PROMPT
Buatkan draf berita resmi berbahasa Indonesia untuk keperluan
publikasi Humas PTSP.

Gunakan informasi yang diberikan penulis saja.

ATURAN PENULISAN:
1. Gunakan bahasa jurnalistik yang formal, jelas, netral, dan faktual.
2. Susun berita dengan pembukaan, isi, dan penutup yang runtut.
3. Kembangkan informasi tanpa mengubah fakta yang tersedia.
4. Jangan mengarang nama orang, jabatan, kutipan, angka, lokasi,
   hasil kegiatan, atau pernyataan pejabat.
5. Jika informasi tidak tersedia, jangan menebaknya.
6. Jangan menambahkan kutipan langsung yang tidak diberikan penulis.
7. Hindari klaim promosi yang tidak didukung informasi.
8. Keluarkan isi berita saja, dalam paragraf teks biasa.
9. Jangan gunakan Markdown, tag HTML, atau blok kode.
10. Draf wajib diperiksa oleh penulis sebelum diproses lebih lanjut.

DATA DARI PENULIS:

Judul:
{$judul}

Lead atau ringkasan awal:
{$lead}

Tanggal tayang:
{$tanggal}

Buat draf berita berdasarkan informasi tersebut. Jika informasi terlalu
terbatas, tulis secara hati-hati tanpa menambahkan fakta baru.
PROMPT;

        $payload = [
            'contents' => [
                [
                    'role' => 'user',
                    'parts' => [
                        ['text' => $prompt],
                    ],
                ],
            ],
            'generationConfig' => [
                'thinkingConfig' => [
                    'thinkingLevel' => 'low',
                ],
                'maxOutputTokens' => 1500,
            ],
        ];

        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent";

        $retryableStatuses = [429, 500, 502, 503, 504];
        $maxAttempts = 3;
        $response = null;

        for ($attempt = 1; $attempt <= $maxAttempts; $attempt++) {
            try {
                $response = Http::acceptJson()
                    ->connectTimeout(15)
                    ->timeout(120)
                    ->withHeaders([
                        'x-goog-api-key' => $apiKey,
                    ])
                    ->post($url, $payload);

                // Tidak mengulang request untuk error seperti 400, 403,
                // atau 404 karena perlu memperbaiki konfigurasi terlebih dahulu.
                if (! in_array(
                    $response->status(),
                    $retryableStatuses,
                    true
                )) {
                    break;
                }

                if ($attempt < $maxAttempts) {
                    $retryAfter = $response->header('Retry-After');

                    $delay = is_numeric($retryAfter)
                        ? min(10, max(1, (int) $retryAfter))
                        : $attempt * 2;

                    sleep($delay);
                }
            } catch (ConnectionException $exception) {
                report($exception);

                if ($attempt === $maxAttempts) {
                    throw new RuntimeException(
                        'Koneksi ke Gemini gagal setelah '
                        . $maxAttempts
                        . ' percobaan. Periksa koneksi internet dan coba lagi.',
                        0,
                        $exception
                    );
                }

                sleep($attempt * 2);
            }
        }

        if ($response === null) {
            throw new RuntimeException(
                'Gemini tidak memberikan respons. Silakan coba lagi.'
            );
        }

        if ($response->failed()) {
            $status = $response->status();

            $errorMessage = data_get(
                $response->json(),
                'error.message',
                'Tidak ada detail error dari Google.'
            );

            if (! is_string($errorMessage)) {
                $errorMessage = json_encode($errorMessage)
                    ?: 'Detail error tidak tersedia.';
            }

            report(new RuntimeException(
                "Gemini API gagal. HTTP {$status}. {$errorMessage}"
            ));

            if (in_array($status, [429, 500, 502, 503, 504], true)) {
                throw new RuntimeException(
                    "Gemini masih bermasalah (HTTP {$status}) "
                    . 'setelah beberapa percobaan. Silakan coba lagi nanti.'
                );
            }

            throw new RuntimeException(
                "Gemini API gagal (HTTP {$status}). {$errorMessage}"
            );
        }

        $result = $response->json();

        $parts = data_get(
            $result,
            'candidates.0.content.parts',
            []
        );

        $text = collect($parts)
            ->pluck('text')
            ->filter(fn ($part) => is_string($part))
            ->implode("\n");

        $text = trim($text);

        if ($text === '') {
            $finishReason = data_get(
                $result,
                'candidates.0.finishReason',
                'tidak diketahui'
            );

            throw new RuntimeException(
                'Gemini tidak mengembalikan teks yang dapat digunakan. '
                . "Alasan penyelesaian: {$finishReason}."
            );
        }

        return $this->plainTextToHtml($text);
    }

    /**
     * Mengubah teks biasa menjadi paragraf HTML sederhana
     * yang dapat ditampilkan oleh Filament RichEditor.
     */
    private function plainTextToHtml(string $text): string
    {
        $text = str_replace(["\r\n", "\r"], "\n", $text);

        $paragraphs = preg_split(
            '/\n\s*\n/',
            trim($text)
        ) ?: [];

        $html = [];

        foreach ($paragraphs as $paragraph) {
            $paragraph = trim($paragraph);

            if ($paragraph === '') {
                continue;
            }

            // Escape keluaran AI agar tidak diperlakukan sebagai HTML.
            $escaped = e($paragraph);

            $html[] = '<p>'
                . nl2br($escaped, false)
                . '</p>';
        }

        return implode("\n", $html);
    }
}
