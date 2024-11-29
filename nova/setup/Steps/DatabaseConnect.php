<?php

declare(strict_types=1);

namespace Nova\Setup\Steps;

use Illuminate\Support\Facades\Blade;

class DatabaseConnect extends Step
{
    public function icon(): string
    {
        return Blade::render('<x-icon name="tabler-database-cog" size="md">');
    }

    public function title(): string
    {
        return 'Connect to my database';
    }

    public function isComplete(): bool
    {
        return file_exists(nova_path('config/database.php'));
    }

    public function isCurrent(): bool
    {
        return request()->is('setup/database');
    }
}
