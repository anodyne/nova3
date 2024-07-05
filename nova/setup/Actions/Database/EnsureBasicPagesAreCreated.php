<?php

declare(strict_types=1);

namespace Nova\Setup\Actions\Database;

use Lorisleiva\Actions\Concerns\AsAction;

class EnsureBasicPagesAreCreated
{
    use AsAction;

    public function handle(): void
    {
        activity()->disableLogging();

        activity()->enableLogging();
    }

    public function present(): bool
    {
        return true;
    }
}
