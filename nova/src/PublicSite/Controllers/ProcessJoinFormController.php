<?php

declare(strict_types=1);

namespace Nova\PublicSite\Controllers;

use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Support\Facades\RateLimiter;
use Nova\Applications\Actions\CreateApplicationManager;
use Nova\Foundation\Controllers\Controller;
use Nova\PublicSite\Requests\StoreApplicationRequest;

class ProcessJoinFormController extends Controller
{
    public function __invoke(StoreApplicationRequest $request)
    {
        $executed = RateLimiter::attempt(
            key: 'process-join:'.$request->input('userInfo.email'),
            maxAttempts: 1,
            callback: fn () => CreateApplicationManager::run($request),
            decaySeconds: 15 * 60
        );

        if (! $executed) {
            throw new ThrottleRequestsException;
        }

        return back()->with('join-submitted', 'yes');
    }
}
