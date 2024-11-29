<?php

declare(strict_types=1);

namespace Nova\Setup\Steps;

class VerifyServer extends Step
{
    public function icon(): string
    {
        if ($this->isComplete()) {
            return;
        }

    }

    public function title(): string
    {
        return 'Can I run Nova?';
    }

    public function isComplete(): bool
    {
        return nova()->environment()->passes();
    }

    public function isCurrent(): bool
    {
        return request()->is('setup');
    }
}
