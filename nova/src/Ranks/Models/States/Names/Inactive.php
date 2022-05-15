<?php

declare(strict_types=1);

namespace Nova\Ranks\Models\States\Names;

class Inactive extends RankNameStatus
{
    public static $name = 'inactive';

    public function color(): string
    {
        return 'gray';
    }

    public function bgColor(): string
    {
        return "bg-{$this->color()}-400 dark:bg-{$this->color()}-500";
    }

    public function name(): string
    {
        return 'inactive';
    }
}
