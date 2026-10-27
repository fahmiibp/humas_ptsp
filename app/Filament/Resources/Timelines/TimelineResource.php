<?php

namespace App\Filament\Resources\Timelines;

use App\Filament\Resources\Timelines\Pages\CreateTimeline;
use App\Filament\Resources\Timelines\Pages\EditTimeline;
use App\Filament\Resources\Timelines\Pages\ListTimelines;
use App\Filament\Resources\Timelines\Pages\ViewTimeline;
use App\Filament\Resources\Timelines\Schemas\TimelineForm;
use App\Filament\Resources\Timelines\Schemas\TimelineInfolist;
use App\Filament\Resources\Timelines\Tables\TimelinesTable;
use App\Models\Timeline;
use BackedEnum;
use Carbon\Carbon;
use Filament\GlobalSearch\Actions\Action;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use UnitEnum;

class TimelineResource extends Resource
{
    protected static string | UnitEnum | null $navigationGroup = 'Manajemen Agenda';

    protected static ?int $navigationSort = 1;

    protected static ?string $model = Timeline::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static string|BackedEnum|null $activeNavigationIcon = Heroicon::CalendarDays;

    protected static ?string $navigationLabel = 'Agenda Liputan';

    protected static ?string $modelLabel = 'Agenda Kegiatan';

    protected static ?string $pluralModelLabel = 'Daftar Agenda Kegiatan';

    protected static ?string $recordTitleAttribute = 'event_name';

    public static function form(Schema $schema): Schema
    {
        return TimelineForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return TimelineInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TimelinesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    /**
     * Menampilkan jumlah kegiatan yang sedang berlangsung atau aktif di badge sidebar
     */
    public static function getNavigationBadge(): ?string
    {
        $activeCount = static::getModel()::where('status', 'Sedang Berlangsung')->count();

        return $activeCount > 0 ? (string) $activeCount : null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function getNavigationBadgeTooltip(): ?string
    {
        return 'Jumlah agenda yang sedang berlangsung saat ini';
    }

    /**
     * Kolom pencarian global (Ctrl + K)
     */
    public static function getGloballySearchableAttributes(): array
    {
        return ['event_name', 'location', 'status'];
    }

    /**
     * Judul yang muncul pada hasil pencarian global
     */
    public static function getGlobalSearchResultTitle(Model $record): string | Htmlable
    {
        return $record->event_name;
    }

    /**
     * Rincian pendukung di bawah judul hasil pencarian global
     */
    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $start = Carbon::parse($record->start_date)->translatedFormat('d M Y');
        $end = Carbon::parse($record->end_date)->translatedFormat('d M Y');
        $periode = $start === $end ? $start : "{$start} - {$end}";

        return [
            'Lokasi' => $record->location ?? '-',
            'Waktu' => $periode,
            'Status' => $record->status ?? '-',
        ];
    }

    /**
     * Aksi cepat langsung dari dialog Global Search
     */
    public static function getGlobalSearchResultActions(Model $record): array
    {
        return [
            Action::make('view')
                ->label('Lihat Detail')
                ->icon('heroicon-m-eye')
                ->url(static::getUrl('view', ['record' => $record])),

            Action::make('edit')
                ->label('Ubah')
                ->icon('heroicon-m-pencil-square')
                ->url(static::getUrl('edit', ['record' => $record])),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTimelines::route('/'),
            'create' => CreateTimeline::route('/create'),
            'view' => ViewTimeline::route('/{record}'),
            'edit' => EditTimeline::route('/{record}/edit'),
        ];
    }
}
