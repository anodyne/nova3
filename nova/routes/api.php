<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Nova\Foundation\Controllers\Api\HeartbeatController;
use Nova\Foundation\Controllers\Api\SyncExternalContentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('heartbeat', HeartbeatController::class);

Route::get('sync-content', SyncExternalContentController::class);

Route::get('version', function () {
    return response()->json([
        'severity' => 'patch',
        'version' => '3.0.1',
        'notes' => 'Sint eiusmod esse sint elit anim aliqua non ex consectetur.',
    ]);
});
