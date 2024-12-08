<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Date;
use Nova\Foundation\Models\SystemInfo;
use Nova\Foundation\Nova;
use TimoKoerber\LaravelOneTimeOperations\OneTimeOperation;

return new class extends OneTimeOperation
{
    protected bool $async = false;

    protected string $queue = 'default';

    protected ?string $tag = null;

    public function process(): void
    {
        SystemInfo::create([
            'version' => Nova::filesVersion(),
            'install_date' => Date::now(),
        ]);
    }
};
