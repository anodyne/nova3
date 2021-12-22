<?php

declare(strict_types=1);

namespace Tests;

trait UsesSettings
{
    protected function updateSetting($callback): void
    {
        $settings = settings();

        $callback($settings);

        $settings->save();
    }
}
