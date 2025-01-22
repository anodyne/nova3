<?php

declare(strict_types=1);

namespace Nova\Foundation\Concerns;

use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity as BaseLogsActivityTrait;

trait LogsActivity
{
    use BaseLogsActivityTrait;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty();
    }

    public function tapActivity(Activity $activity, string $eventName)
    {
        $impersonator = app('impersonate');

        if ($impersonator->isImpersonating()) {
            $activity->log_name = 'impersonation';
            $activity->properties = $activity->properties->merge([
                'impersonated_by' => $impersonator->getImpersonatorId(),
                'impersonated_user' => Auth::id(),
            ]);
        }
    }
}
