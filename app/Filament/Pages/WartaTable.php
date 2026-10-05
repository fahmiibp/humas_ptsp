<?php

namespace App\Filament\Pages;

use App\Models\Warta;
use BackedEnum;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Pages\Page;
use Filament\Schemas\Concerns\InteractsWithSchemas;
use Filament\Schemas\Concerns\RestrictsFileUploadsToSchemaComponents;
use Filament\Schemas\Contracts\HasSchemas;
use Filament\Support\Enums\TextSize;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use UnitEnum;

class WartaTable extends Page implements HasActions, HasSchemas, HasTable
{
    use InteractsWithActions;
    use InteractsWithSchemas;
    use InteractsWithTable;
    use RestrictsFileUploadsToSchemaComponents;

    protected static string | UnitEnum | null $navigationGroup = 'Produksi Konten';
    protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedGlobeAlt;

    protected string $view = 'filament.pages.warta-table';

    // 1. Simpan status tab aktif di properti Livewire ini
    public ?string $activeTab = 'semua';

    public function table(Table $table): Table
    {
        return $table
            // 2. Filter query database sesuai $activeTab yang dipilih
            ->query(
                Warta::query()
                    ->when($this->activeTab === 'butuh_review', fn ($query) => $query->where('status_naskah', 'Draft Penulis'))
                    ->when($this->activeTab === 'siap_tayang', fn ($query) => $query->where('status_naskah', 'Disetujui'))
                    ->when($this->activeTab === 'sudah_tayang', fn ($query) => $query->where('status_naskah', 'Tayang'))
            )
            ->contentGrid([
                'md' => 2,
                'lg' => 3,
                'xl' => 3,
            ])
            ->columns([
    Stack::make([
        // 1. Gambar Utama dengan Efek Hover Zoom & Overflow Hidden
        ImageColumn::make('dokumentasi_utama')
            ->disk('public')
            ->height('190px')
            ->width('100%')
            ->extraImgAttributes([
                'class' => 'object-cover rounded-t-xl w-full transition-transform duration-500 group-hover:scale-105',
            ]),

        // 2. Container Isi Kartu (dengan padding & border bawah)
        Stack::make([
            // Header Kartu: Status Badge + Tanggal
            Split::make([
                TextColumn::make('status_naskah')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Draft Penulis' => 'warning',
                        'Disetujui'     => 'info',
                        'Tayang'        => 'success',
                        default         => 'gray',
                    })
                    ->icon(fn (string $state): ?string => match ($state) {
                        'Draft Penulis' => 'heroicon-m-clock',
                        'Disetujui'     => 'heroicon-m-check-circle',
                        'Tayang'        => 'heroicon-m-sparkles',
                        default         => null,
                    }),

                TextColumn::make('created_at')
                    ->date('d M Y')
                    ->icon('heroicon-m-calendar')
                    ->color('gray')
                    ->size(TextSize::ExtraSmall)
                    ->alignEnd(),
            ])->extraAttributes(['class' => 'items-center']),

            // Judul & Lead Berita
            Stack::make([
                TextColumn::make('judul_siaran_pers')
                    ->weight('bold')
                    ->size(TextSize::Large)
                    ->lineClamp(2)
                    ->extraAttributes([
                        'class' => 'text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors',
                    ]),

                TextColumn::make('lead_berita')
                    ->color('gray')
                    ->size(TextSize::Small)
                    ->lineClamp(2)
                    ->extraAttributes([
                        'class' => 'leading-relaxed text-gray-500 dark:text-gray-400',
                    ]),
            ])->space(2),

        ])
        ->space(3)
        ->extraAttributes([
            'class' => 'p-4 bg-white dark:bg-gray-900 rounded-b-xl border-x border-b border-gray-200/70 dark:border-gray-800 shadow-sm',
        ]),
    ]),
])
            ->filters([
                // ...
            ])
            ->recordActions([
                // ...
            ])
            ->toolbarActions([
                // ...
            ]);
    }
}