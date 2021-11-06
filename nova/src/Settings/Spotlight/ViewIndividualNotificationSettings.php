<?php

declare(strict_types=1);

namespace Nova\Settings\Spotlight;

use Illuminate\Support\Facades\Gate;
use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;

class ViewIndividualNotificationSettings extends SpotlightCommand
{
    protected string $name = 'Individual Notification Settings';

    protected string $description = "View Nova's individual notification settings";

    protected array $synonyms = [
        'email', 'web', 'published', 'received',
    ];

    public function execute(Spotlight $spotlight): void
    {
        $spotlight->redirectRoute('settings.index', 'individual-notifications');
    }

    public function shouldBeShown(): bool
    {
        return Gate::allows('update', settings());
    }
}
