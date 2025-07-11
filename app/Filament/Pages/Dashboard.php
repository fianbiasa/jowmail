<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\CampaignChart;
use App\Filament\Widgets\ClickOpenPie;


class Dashboard extends BaseDashboard
{
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