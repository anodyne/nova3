<?php

declare(strict_types=1);

namespace Nova\PublicSite\Controllers;

use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Support\Facades\RateLimiter;
use Nova\Foundation\Controllers\Controller;
use Nova\PublicSite\Actions\HandleContactForm;
use Nova\PublicSite\Requests\ContactRequest;
use Spatie\Honeypot\ProtectAgainstSpam;

class ProcessContactFormController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware(ProtectAgainstSpam::class);
    }

    public function __invoke(ContactRequest $request)
    {
        $executed = RateLimiter::attempt(
            key: 'process-contact:'.$request->ip(),
            maxAttempts: 1,
            callback: fn () => HandleContactForm::run($request),
            decaySeconds: 15 * 60
        );

        if (! $executed) {
            throw new ThrottleRequestsException;
        }

        return back()->with('contact-submitted', 'yes');
    }
}
