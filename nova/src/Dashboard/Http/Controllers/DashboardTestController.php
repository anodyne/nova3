<?php

namespace Nova\Dashboard\Http\Controllers;

use Nova\Foundation\Http\Controllers\Controller;

class DashboardTestController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke()
    {
        // $this->dispatchBrowserEvent('notify', 'Dashboard');

        session()->flash('nova.notify', 'Message');

        return redirect('/dashboard');
    }
}
