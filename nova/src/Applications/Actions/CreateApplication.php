<?php

declare(strict_types=1);

namespace Nova\Applications\Actions;

use Nova\Applications\Data\ApplicationData;
use Nova\Applications\Models\Application;
use Nova\Foundation\Actions\Action;

class CreateApplication extends Action
{
    public function handle(ApplicationData $data): Application
    {
        return Application::create($data->toArray());
    }
}
