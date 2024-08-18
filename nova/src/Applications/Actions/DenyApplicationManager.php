<?php

declare(strict_types=1);

namespace Nova\Applications\Actions;

use Illuminate\Support\Facades\DB;
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
        DB::beginTransaction();

        try {
            HideCharacter::run($application->character);

            HideUser::run($application->user);

            $application = DenyApplication::run($application, $data->message);

            $application->user->notify(new ApplicationDenied($application));

            ApplicationDeniedEvent::dispatch($application);

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }
}
