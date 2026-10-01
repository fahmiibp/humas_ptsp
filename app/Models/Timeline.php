<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Timeline extends Model
{
    protected $table = 'timeline';

    protected $fillable = [
        'event_name',
        'start_date',
        'end_date',
        'location',
        'status',
    ];

    /**
     * Accessor Status Realtime
     */
    public function getStatusAttribute($value): string
    {
        // 1. Ambil nilai status asli dari DB (tanpa spasi berlebih)
        $rawStatus = trim((string) $value);

        // 2. Jika status di DB adalah 'Batal' (atau 'batal'), WAJIB kembalikan 'Batal'
        if (strtolower($rawStatus) === 'batal') {
            return 'Batal';
        }

        // 3. Cegah error jika tanggal belum diisi
        if (! $this->start_date || ! $this->end_date) {
            return $rawStatus ?: 'Belum Mulai';
        }

        // 4. Hitung status otomatis berdasarkan tanggal hari ini jika tidak dibatalkan
        $today = now()->startOfDay();
        $startDate = Carbon::parse($this->start_date)->startOfDay();
        $endDate = Carbon::parse($this->end_date)->endOfDay();

        if ($today->lt($startDate)) {
            return 'Belum Mulai';
        }

        if ($today->between($startDate, $endDate)) {
            return 'Sedang Berlangsung';
        }

        return 'Selesai';
    }
}