<?php

declare(strict_types=1);

namespace Nova\Settings\Spotlight;

use Illuminate\Support\Facades\Gate;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;

class ViewNotificationSettings extends SpotlightCommand
{
    protected string $name = 'Notification Settings';

    protected string $description = "View Nova's notification settings";

    protected array $synonyms = [
        'discord settings', 'webhook',
    ];

    public function execute(Spotlight $spotlight): void
    {
        $spotlight->redirectRoute('admin.settings.notifications.edit');
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('update', settings());
    }
}
