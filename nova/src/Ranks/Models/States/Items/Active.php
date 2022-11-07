<?php

declare(strict_types=1);

namespace Nova\Ranks\Models\States\Items;

class Active extends RankItemStatus
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
