<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah Pengguna')
                ->icon('heroicon-m-user-plus')
                ->modalHeading('Buat Pengguna Baru')
                ->modalDescription('Lengkapi formulir di bawah ini untuk menambahkan akun pengguna baru ke sistem.')
                ->modalWidth('2xl') // Responsif & leluasa untuk form dengan Grid
                ->modalIcon('heroicon-o-user-plus')
                ->modalSubmitActionLabel('Simpan Akun')
                ->modalCancelActionLabel('Batal')
                ->slideOver(false) // Tetap modal center yang rapi di desktop & mobile
                ->mutateFormDataUsing(function (array $data): array {
                    if (empty($data['avatar'])) {
                        $data['avatar'] = null;
                    }
                    return $data;
                })
                ->successNotification(
                    Notification::make()
                        ->success()
                        ->title('Pengguna Berhasil Ditambahkan')
                        ->body('Akun baru telah dibuat dan siap digunakan.')
                ),
        ];
    }
}
