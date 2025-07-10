<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class TrackingController extends Controller
{
    public function open($campaignId, $subscriberId)
    {
        // Simpan log ke tabel pivot atau log terbuka
        DB::table('campaign_opens')->updateOrInsert(
            [
                'campaign_id' => $campaignId,
                'subscriber_id' => $subscriberId,
            ],
            [
                'opened_at' => now(),
            ]
        );

        // Kembalikan 1x1 transparent pixel
        $pixel = base64_decode(
            'R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==' // GIF 1x1 pixel
        );

        return Response::make($pixel, 200, [
            'Content-Type' => 'image/gif',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }
}