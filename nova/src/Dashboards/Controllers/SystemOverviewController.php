<?php

declare(strict_types=1);

namespace Nova\Dashboards\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Nova\Dashboards\Responses\SystemOverviewResponse;
use Nova\Foundation\Controllers\Controller;

class SystemOverviewController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke()
    {
        return SystemOverviewResponse::send();
    }

    protected function checkForLatestVersion()
    {
        if (Cache::missing('nova-latest-version')) {
            $upstream = Http::get('https://anodyne-productions.com/api/nova/latest-version');

            Cache::put('nova-latest-version', $upstream->json(), now()->addDay());
        }

        ray(Cache::get('nova-latest-version'));
    }
}
