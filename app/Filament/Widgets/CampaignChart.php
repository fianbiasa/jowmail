<?php

namespace App\Filament\Widgets;

use Filament\Widgets\BarChartWidget;
use App\Models\Campaign;

class CampaignChart extends BarChartWidget
{
    protected static ?string $heading = 'Campaigns per Month';

    protected function getData(): array
    {
        $data = Campaign::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $months = range(1, 12);
        $counts = [];

        foreach ($months as $month) {
            $counts[] = $data[$month] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Campaigns',
                    'data' => $counts,
                ],
            ],
            'labels' => [
                'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
            ],
        ];
    }
}