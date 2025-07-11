<?php

namespace App\Filament\Widgets;

use App\Models\CampaignOpen;
use App\Models\CampaignClick;
use Filament\Widgets\PieChartWidget;

class ClickOpenPie extends PieChartWidget
{
    protected static ?string $heading = 'Open vs Clicks';

    protected function getData(): array
    {
        $opens = CampaignOpen::count();
        $clicks = CampaignClick::count();

        return [
            'datasets' => [
                [
                    'data' => [$opens, $clicks],
                    'backgroundColor' => ['#4caf50', '#f44336'],
                ],
            ],
            'labels' => ['Opens', 'Clicks'],
        ];
    }
}