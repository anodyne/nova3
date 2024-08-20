<?php

declare(strict_types=1);

namespace Nova\PublicSite\Controllers;

use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Support\Facades\RateLimiter;
use Nova\Applications\Actions\CreateApplicationManager;
use Nova\Foundation\Controllers\Controller;
use Nova\PublicSite\Requests\ContactRequest;

class ProcessContactFormController extends Controller
{
    public function __invoke(ContactRequest $request)
    {
        $executed = RateLimiter::attempt(
            key: 'process-contact:'.$request->ip(),
            maxAttempts: 1,
            callback: fn () => CreateApplicationManager::run($request),
            decaySeconds: 15 * 60
        );

        if (! $executed) {
            throw new ThrottleRequestsException;
        }

        return back()->with('contact-submitted', 'yes');
    }
}
