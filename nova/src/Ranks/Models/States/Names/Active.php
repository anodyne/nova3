<?php

declare(strict_types=1);

namespace Nova\Ranks\Models\States\Names;

class Active extends RankNameStatus
{
    public static $name = 'active';

    public function color(): string
    {
        return 'success';
    }

    public function bgColor(): string
    {
        return "bg-{$this->color()}-500";
    }

    public function name(): string
    {
        return 'active';
    }
}