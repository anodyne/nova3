<?php

namespace Nova\Setup\Http\Controllers;

use Illuminate\Support\Facades\Artisan;

class SetupController
{
    public function index()
    {
        return view('pages.setup.index');
    }

    public function install()
    {
        Artisan::call('migrate:fresh', ['--force' => true]);
        Artisan::call('db:seed');
        Artisan::call('optimize:clear');
        Artisan::call('package:discover');

        return redirect()->route('login');
    }
}
