<?php

namespace App\Filament\Widgets;

use App\Models\AlumniProfile;
use App\Models\Event;
use App\Models\JobPosting;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalAlumni = AlumniProfile::count();
        $pendingAlumni = AlumniProfile::where('status', 'pending')->count();
        $activeJobs = JobPosting::where('is_active', true)->count();
        $upcomingEvents = Event::where('is_active', true)->where('event_date', '>=', now())->count();

        return [
            Stat::make('Toplam Mezun', $totalAlumni)
                ->description('Sisteme kayıtlı mezunlar')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('success'),
            Stat::make('Onay Bekleyenler', $pendingAlumni)
                ->description('İncelenmesi gereken kayıtlar')
                ->descriptionIcon('heroicon-m-clock')
                ->color($pendingAlumni > 0 ? 'warning' : 'gray'),
            Stat::make('Aktif İlanlar', $activeJobs)
                ->description('Açık iş ve staj fırsatları')
                ->descriptionIcon('heroicon-m-briefcase')
                ->color('primary'),
            Stat::make('Yaklaşan Etkinlikler', $upcomingEvents)
                ->description('Aktif mezun buluşmaları')
                ->descriptionIcon('heroicon-m-calendar')
                ->color('info'),
        ];
    }
}
