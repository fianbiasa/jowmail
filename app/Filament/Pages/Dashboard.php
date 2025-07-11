<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\CampaignChart;
use App\Filament\Widgets\ClickOpenPie;


class Dashboard extends BaseDashboard
{   
    public static function shouldRegisterNavigation(): bool
{
    return false; // nonaktifkan menu dashboard default
}
    protected function getHeaderWidgets(): array
    {
        return [
            StatsOverview::class,
        ];
    }
    protected function getFooterWidgets(): array
{
    return [
        ClickOpenPie::class,
        CampaignChart::class,
    ];
}
}