<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class TrackingController extends Controller
{
    public function open($campaignId, $subscriberId)
    {
    // Cek apakah sudah tercatat sebelumnya
    $exists = \DB::table('campaign_opens')
        ->where('campaign_id', $campaignId)
        ->where('subscriber_id', $subscriberId)
        ->exists();

    if (! $exists) {
        \DB::table('campaign_opens')->insert([
            'campaign_id' => $campaignId,
            'subscriber_id' => $subscriberId,
            'opened_at' => now(),
        ]);
        \Log::info("Open tracked: Campaign $campaignId, Subscriber $subscriberId");
    }

    // Kirim 1x1 GIF transparan agar client tidak error
    $gif = base64_decode(
        'R0lGODlhAQABAPAAAAAAAAAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw=='
    );

    return response($gif)
        ->header('Content-Type', 'image/gif')
        ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
        ->header('Pragma', 'no-cache')
        ->header('Expires', '0');
    }
}