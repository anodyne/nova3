<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks;

class PageBlockRegistry
{
    public static function blocks(): array
    {
        return [
            Hero\StackedHeroBlock::make(Hero\StackedHeroBlock::component),
            Hero\SplitHeroBlock::make(Hero\SplitHeroBlock::component),
            Hero\ImageTilesHeroBlock::make(Hero\ImageTilesHeroBlock::component),
        ];
    }
}
