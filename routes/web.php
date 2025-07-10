<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TrackingController;
use App\Models\Campaign;
use App\Models\Subscriber;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/waktu', function () {
    return now()->toDateTimeString();
});
Route::get('/track/open/{campaignId}/{subscriberId}.png', [TrackingController::class, 'open'])
    ->name('track.open');

Route::get('/tracking/open/{campaign}/{subscriber}', [TrackingController::class, 'open'])->name('tracking.open');    
Route::get('/tracking/open/{campaign}/{subscriber}', function ($campaignId, $subscriberId) {
    $campaign = Campaign::findOrFail($campaignId);
    $subscriber = Subscriber::findOrFail($subscriberId);

    // Update opens
    $subscriber->increment('opens');

    // Return 1x1 transparent GIF
    return response(base64_decode(
        'R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw=='
    ), 200, [
        'Content-Type' => 'image/gif',
        'Cache-Control' => 'no-cache, no-store, must-revalidate',
        'Pragma' => 'no-cache',
        'Expires' => '0',
    ]);
});