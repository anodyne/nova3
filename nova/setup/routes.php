<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Nova\Setup\Controllers\StartSetupController;
use Nova\Setup\Livewire\ConfigureDatabase;
use Nova\Setup\Livewire\InstallNova;
use Nova\Setup\Livewire\MigrateNova;
use Nova\Setup\Livewire\MigrateNovaSteps;
use Nova\Setup\Livewire\SetupAccount;
use Nova\Setup\Livewire\UserAccess;

Route::prefix('setup')->group(function () {
    Route::get('/', StartSetupController::class);
    Route::get('configure-database', ConfigureDatabase::class);
    Route::get('install', InstallNova::class);
    Route::get('setup-account', SetupAccount::class);

    Route::prefix('migrate')->group(function () {
        Route::get('/', MigrateNova::class);
        Route::get('configure-database', ConfigureDatabase::class);
        Route::get('steps', MigrateNovaSteps::class);
        Route::get('set-user-access', UserAccess::class);
    });
});
