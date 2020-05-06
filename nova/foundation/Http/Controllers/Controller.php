<?php

namespace Nova\Foundation\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    public function __construct()
    {
    }

    public function dispatchBrowserEvent($event, $data = null)
    {
        session()->push('nova.dispatchQueue', [
            'event' => $event,
            'data' => $data,
        ]);
    }
}
