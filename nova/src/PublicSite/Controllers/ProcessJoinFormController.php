<?php

declare(strict_types=1);

namespace Nova\PublicSite\Controllers;

use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Illuminate\Support\Facades\RateLimiter;
use Nova\Applications\Actions\CreateApplicationFromJoinFormManager;
use Nova\Foundation\Controllers\Controller;
use Nova\PublicSite\Requests\StoreApplicationRequest;
use Throwable;

class ProcessJoinFormController extends Controller
{
    public function __invoke(StoreApplicationRequest $request)
    {
        abort_unless(settings('applications.enabled'), 404);

        try {
            $executed = RateLimiter::attempt(
                key: 'process-join:'.$request->input('userInfo.email'),
                maxAttempts: 1,
                callback: fn (): mixed => CreateApplicationFromJoinFormManager::run($request),
                decaySeconds: 15 * 60
            );

            if (! $executed) {
                throw new ThrottleRequestsException;
            }

            return back()->with('join-submitted', 'yes');
        } catch (ThrottleRequestsException $th) {
            throw $th;
        } catch (Throwable $th) {
            report($th);

            return back()->with('join-submitted', 'no');
        }
    }
}
