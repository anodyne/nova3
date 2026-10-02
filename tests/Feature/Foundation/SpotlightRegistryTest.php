<?php

declare(strict_types=1);

use LivewireUI\Spotlight\Spotlight;
use LivewireUI\Spotlight\SpotlightCommand;

test('application refreshes preserve Spotlight commands without accumulating duplicates', function (): void {
    $commandClasses = collect(Spotlight::$commands)
        ->map(fn (SpotlightCommand $command): string => $command::class)
        ->all();

    expect($commandClasses)->not->toBeEmpty();

    $this->refreshApplication();
    $this->refreshApplication();

    expect(collect(Spotlight::$commands)
        ->map(fn (SpotlightCommand $command): string => $command::class)
        ->all())->toBe($commandClasses);
});
