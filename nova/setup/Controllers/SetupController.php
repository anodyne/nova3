<?php

declare(strict_types=1);

namespace Nova\Setup\Controllers;

use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Artisan;
use Nova\Setup\Environment;

class SetupController
{
    public function index()
    {
        $errors = app(Pipeline::class)
            ->send([])
            ->through([
                Environment\EnsurePhpVersion::class,
                Environment\EnsurePhpCtypeExtensionEnabled::class,
                Environment\EnsurePhpCurlExtensionEnabled::class,
                Environment\EnsurePhpDomExtensionEnabled::class,
                Environment\EnsurePhpFileinfoExtensionEnabled::class,
                Environment\EnsurePhpFilterExtensionEnabled::class,
                Environment\EnsurePhpHashExtensionEnabled::class,
                Environment\EnsurePhpMbstringExtensionEnabled::class,
                Environment\EnsurePhpOpenSslExtensionEnabled::class,
                Environment\EnsurePhpPcreExtensionEnabled::class,
                Environment\EnsurePhpPdoExtensionEnabled::class,
                Environment\EnsurePhpSessionExtensionEnabled::class,
                Environment\EnsurePhpTokenizerExtensionEnabled::class,
                Environment\EnsurePhpXmlExtensionEnabled::class,
                Environment\EnsureDatabasePlatform::class,
            ])
            ->thenReturn();

        if (count($errors)) {
            return view('pages.setup.environment', compact('errors'));
        }

        // Is Nova installed?

        // No? Redirect into the install flow

        // Yes? Redirect into the update flow

        return view('pages.setup.index');
    }

    public function install()
    {
        Artisan::call('migrate:fresh', ['--force' => true]);
        Artisan::call('db:seed');
        Artisan::call('optimize:clear');
        Artisan::call('package:discover');

        return redirect('/login');
    }
}
