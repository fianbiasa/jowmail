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
public function getHeaderWidgets(): array
{
    return [
        StatsOverview::class,
    ];
}

public function getFooterWidgets(): array
{
    return [
        CampaignChart::class,
        ClickOpenPie::class,
    ];
}
}