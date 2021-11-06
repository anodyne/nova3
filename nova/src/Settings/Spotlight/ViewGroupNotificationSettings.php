<?php

declare(strict_types=1);

namespace Nova\Settings\Spotlight;

use Illuminate\Support\Facades\Gate;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;

class ViewGroupNotificationSettings extends SpotlightCommand
{
    protected string $name = 'Group Notification Settings';

    protected string $description = "View Nova's group notification settings";

    protected array $synonyms = [
        'discord', 'email', 'web', 'published', 'received',
    ];

    public function execute(Spotlight $spotlight): void
    {
        $spotlight->redirectRoute('settings.index', 'group-notifications');
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('update', settings());
    }
}
