<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Log;

class TrackingController extends Controller
{
    public function open($campaignId, $subscriberId)
    {
        $exists = DB::table('campaign_opens')
            ->where('campaign_id', $campaignId)
            ->where('subscriber_id', $subscriberId)
            ->exists();

        if (! $exists) {
            DB::table('campaign_opens')->insert([
                'campaign_id' => $campaignId,
                'subscriber_id' => $subscriberId,
                'opened_at' => now(),
            ]);
            Log::info("Open tracked: Campaign $campaignId, Subscriber $subscriberId");
        }

        $gif = base64_decode('R0lGODlhAQABAPAAAAAAAAAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==');

        return response($gif)
            ->header('Content-Type', 'image/gif')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function redirect(Request $request)
    {
        $id = $request->query('id');
        $ref = $request->query('ref');

        if (! $id || ! $ref) {
            abort(404, 'Missing tracking parameters.');
        }

        try {
            $decodedId = base64_decode($id);
            $decodedUrl = base64_decode(urldecode($ref));
            [$hash, $subscriberId, $campaignId] = explode('.', $decodedId);

            DB::table('campaign_clicks')->insert([
                'campaign_id' => $campaignId,
                'subscriber_id' => $subscriberId,
                'clicked_url' => $decodedUrl,
                'clicked_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            Log::info("Link clicked: Campaign $campaignId, Subscriber $subscriberId → $decodedUrl");

            return redirect()->away($decodedUrl);
        } catch (\Exception $e) {
            Log::error('Redirect tracking error: ' . $e->getMessage());
            abort(404, 'Unable to process tracking link.');
        }
    }

    public function unsubscribe(Request $request, $subscriberId)
    {
        $subscriber = DB::table('subscribers')->where('id', $subscriberId)->first();

        if (! $subscriber) {
            abort(404, 'Subscriber not found.');
        }

        if ($request->isMethod('post')) {
            DB::table('subscribers')->where('id', $subscriberId)->delete();
            return view('unsubscribe.confirmed');
        }

        return view('unsubscribe.confirm', ['subscriber' => $subscriber]);
    }
}