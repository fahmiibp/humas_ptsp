<?php

namespace App\Support;

use Filament\Notifications\Notification;
use Laravel\Ai\Exceptions\ProviderOverloadedException;
use Laravel\Ai\Exceptions\RateLimitedException;

class AiHelper
{
    public static function tanya(string $agentClass, string $prompt): ?string
    {
        try {
            $hasil = retry(
                3,
                fn() => $agentClass::make()->prompt($prompt),
                1500,
                fn($e) => $e instanceof ProviderOverloadedException
            );

            return trim((string) $hasil);
        } catch (ProviderOverloadedException $e) {
            Notification::make()
                ->title('Layanan AI sedang sibuk')
                ->body('Coba lagi beberapa saat.')
                ->warning()
                ->send();
        } catch (RateLimitedException $e) {
            report($e);
            Notification::make()
                ->title('Batas penggunaan AI tercapai')
                ->body('Coba lagi nanti atau hubungi admin.')
                ->warning()
                ->send();
        } catch (\Throwable $e) {
            report($e);
            Notification::make()
                ->title('Gagal menghubungi AI')
                ->body('Coba lagi beberapa saat.')
                ->danger()
                ->send();
        }

        return null;
    }
}
