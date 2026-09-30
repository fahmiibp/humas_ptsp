<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

// 1. Tambahkan dua baris import ini
use Filament\Models\Contracts\HasAvatar;
use Illuminate\Support\Facades\Storage;

#[Fillable(['name', 'email', 'password', 'avatar'])]
#[Hidden(['password', 'remember_token'])]
// 2. Tambahkan 'implements HasAvatar' pada deklarasi class
class User extends Authenticatable implements HasAvatar
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * 3. Tambahkan fungsi ini agar Filament tahu dari mana mengambil URL gambar
     */
    public function getFilamentAvatarUrl(): ?string
    {
        // Jika kolom avatar di database tidak kosong, ambil URL gambarnya dari storage
        if ($this->avatar) {
            return Storage::url($this->avatar);
        }

        // Jika kosong, kembalikan null agar Filament menggunakan inisial nama secara default
        return null;
    }
}