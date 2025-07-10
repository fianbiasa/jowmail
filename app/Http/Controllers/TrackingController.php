<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class TrackingController extends Controller
{
    public function open($campaignId, $subscriberId)
    {
        // Simpan ke campaign_opens
        DB::table('campaign_opens')->updateOrInsert(
            [
                'campaign_id' => $campaignId,
                'subscriber_id' => $subscriberId,
            ],
            [
                'opened_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // Return 1x1 transparent GIF
        $pixel = base64_decode('R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==');

        return Response::make($pixel, 200, [
            'Content-Type' => 'image/gif',
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }
}