<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Nova\Foundation\Http\Middleware\CheckAddonAndThemeVersions;
use Nova\Foundation\Http\Middleware\CheckNovaVersion;
use Nova\Setup\Controllers\StartSetupController;
use Nova\Setup\Controllers\UpdateWhatsNewController;
use Nova\Setup\Livewire\ConfigureDatabase;
use Nova\Setup\Livewire\InstallNova;
use Nova\Setup\Livewire\MigrateNova;
use Nova\Setup\Livewire\MigrateNovaData;
use Nova\Setup\Livewire\SetupAccount;
use Nova\Setup\Livewire\UpdateNova;
use Nova\Setup\Livewire\UserAccess;

Route::prefix('setup')->group(function () {
    Route::get('/', StartSetupController::class)->name('setup.start');
    Route::get('configure-database', ConfigureDatabase::class);
    Route::get('install', InstallNova::class);
    Route::get('setup-account', SetupAccount::class);

    Route::prefix('migrate')->group(function () {
        Route::get('/', MigrateNova::class);
        Route::get('configure-database', ConfigureDatabase::class);
        Route::get('steps', MigrateNovaData::class);
        Route::get('set-user-access', UserAccess::class);
    });

    Route::prefix('update')
        ->middleware(['auth', 'permission:site.update'])
        ->group(function () {
            Route::get('/', UpdateNova::class)->name('update.run');
            Route::get('whats-new', UpdateWhatsNewController::class)->name('update.whats-new');
        });
})->withoutMiddleware([
    CheckNovaVersion::class,
    CheckAddonAndThemeVersions::class,
]);
