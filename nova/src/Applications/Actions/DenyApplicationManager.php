<?php

declare(strict_types=1);

namespace Nova\Applications\Actions;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Applications\Data\ApplicationDecisionData;
use Nova\Applications\Events\ApplicationDenied as ApplicationDeniedEvent;
use Nova\Applications\Models\Application;
use Nova\Applications\Notifications\ApplicationDenied;
use Nova\Characters\Actions\HideCharacter;
use Nova\Users\Actions\HideUser;

class DenyApplicationManager
{
    use AsAction;

    public function handle(Application $application, ApplicationDecisionData $data): void
    {
        Gate::forUser(Auth::user())->authorize('decide', $application);

        DB::transaction(function () use ($application, $data): void {
            HideCharacter::run($application->character);

            HideUser::run($application->user);

            $application = DenyApplication::run($application, $data->message);

            $application->user->notify(new ApplicationDenied($application));

            ApplicationDeniedEvent::dispatch($application);

            activity()
                ->performedOn($application)
                ->event('denied')
                ->log('denied');
        });
    }
}
