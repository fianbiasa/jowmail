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
Route::get('/tracking/open/{campaign}/{subscriber}.gif', [TrackingController::class, 'open'])->name('tracking.open');
Route::get('/redirect.php', [TrackingController::class, 'redirect'])->name('tracking.click');
Route::match(['get', 'post'], '/unsubscribe/{subscriber}', [TrackingController::class, 'unsubscribe'])->name('unsubscribe');
Route::get('/redirect', [\App\Http\Controllers\TrackingController::class, 'redirect']);