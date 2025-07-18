<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\ContentRatings;

use Closure;
use Filament\Forms\Components\Toggle;
use Nova\Pages\Blocks\Block as PageBuilderBlock;

abstract class ContentRatingsBlock extends PageBuilderBlock
{
    protected string|Closure $section = 'Content Ratings';

    public function blockSchema(): array
    {
        return [
            Toggle::make('block.dark')
                ->label('My block uses a dark background')
                ->helperText('This will ensure that the colors of each rating will be better tuned to the background'),
        ];
    }
}
