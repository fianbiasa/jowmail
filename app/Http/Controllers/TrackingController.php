<?
namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class TrackingController extends Controller
{
    public function open($campaignId, $subscriberId)
    {
        // Hindari duplikat pencatatan
        DB::table('campaign_opens')->updateOrInsert([
            'campaign_id' => $campaignId,
            'subscriber_id' => $subscriberId,
        ], [
            'opened_at' => now(),
        ]);

        // 1x1 transparent PNG
        $pixel = base64_decode(
            'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR4nGNgYAAAAAMAASsJTYQAAAAASUVORK5CYII='
        );
        return response($pixel, 200)
            ->header('Content-Type', 'image/png');
    }
}