<?php

declare(strict_types=1);

namespace Nova\Applications\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Applications\Data\ApplicationData;
use Nova\Applications\Models\Application;

class CreateApplication
{
    use AsAction;

    public function handle(ApplicationData $data): Application
    {
        return Application::create($data->all());
    }
}
