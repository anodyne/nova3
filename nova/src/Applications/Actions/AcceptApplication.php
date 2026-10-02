<?php

declare(strict_types=1);

namespace Nova\Applications\Actions;

use Nova\Applications\Enums\ApplicationResult;
use Nova\Applications\Models\Application;
use Nova\Foundation\Actions\Action;

class AcceptApplication extends Action
{
    public function handle(Application $application, ?string $message = null): void
    {
        $application->update([
            'result' => ApplicationResult::Accept,
            'decision_message' => $message,
            'decision_date' => now(),
        ]);
    }
}
