<?php

declare(strict_types=1);

namespace Nova\Setup\Actions\Database;

use Lorisleiva\Actions\Concerns\AsAction;

class EnsureAdvancedPagesAreCreated
{
    use AsAction;

    public function handle(): void
    {
        //
    }

    public function present(): bool
    {
        return true;
    }
}
