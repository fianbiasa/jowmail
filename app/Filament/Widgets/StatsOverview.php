<?php

namespace App\Filament\Widgets;

use App\Models\CampaignClick;
use App\Models\CampaignOpen;
use App\Models\Campaign;
use App\Models\EmailList;
use App\Models\Subscriber;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class StatsOverview extends BaseWidget
{
    protected function getCards(): array
    {
        $totalCampaigns = Campaign::count();
        $totalSubscribers = Subscriber::count();
        $totalLists = EmailList::count();

        $totalOpens = CampaignOpen::count();
        $totalClicks = CampaignClick::count();

        $openRate = $totalSubscribers > 0 ? number_format(($totalOpens / $totalSubscribers) * 100, 1) : 0;
        $clickRate = $totalSubscribers > 0 ? number_format(($totalClicks / $totalSubscribers) * 100, 1) : 0;

        return [
            Card::make('Email Lists', $totalLists),
            Card::make('Subscribers', $totalSubscribers),
            Card::make('Campaigns Sent', $totalCampaigns),
            Card::make('Opens', $totalOpens),
            Card::make('Clicks', $totalClicks),
            Card::make('Open Rate', "{$openRate}%"),
            Card::make('Click Rate', "{$clickRate}%"),
        ];
    }
}