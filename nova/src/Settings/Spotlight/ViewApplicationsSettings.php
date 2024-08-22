<?php

declare(strict_types=1);

namespace Nova\Settings\Spotlight;

use Illuminate\Support\Facades\Gate;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;

class ViewApplicationsSettings extends SpotlightCommand
{
    protected string $name = 'Applications Settings';

    protected string $description = "View Nova's applications settings";

    protected array $synonyms = [];

    public function execute(Spotlight $spotlight): void
    {
        $spotlight->redirectRoute('admin.settings.applications.edit');
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('update', settings());
    }
}
