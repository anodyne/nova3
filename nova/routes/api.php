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

Route::middleware('auth:api')->get('/user', fn (Request $request) => $request->user());

Route::name('api.')->group(function (): void {
    Route::get('heartbeat', HeartbeatController::class)
        ->name('heartbeat');

    Route::get('sync-external-content', SyncExternalContentController::class)
        ->name('sync-external-content');

    Route::get('version', function () {
        $notes = "- Fix one\r\n- Fix two\r\n- Fix three";

        return response()->json([
            'severity' => 'patch',
            'version' => '3.0.0-alpha13',
            'description' => 'Irure veniam ad sit ipsum sunt qui. Excepteur anim nulla consectetur pariatur excepteur in elit ad dolore non. Non proident id consequat nisi amet incididunt consequat excepteur elit Lorem.',
            'notes' => $notes,
        ]);
    })->name('latest-version');
});
