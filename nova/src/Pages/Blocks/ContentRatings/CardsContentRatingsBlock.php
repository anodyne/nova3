<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\ContentRatings;

use Closure;
use Filament\Forms\Components\Toggle;

class CardsContentRatingsBlock extends ContentRatingsBlock
{
    const component = 'content-ratings.cards';

    protected ?string $blockLabel = 'Content ratings - Cards';

    protected string|Closure|null $preview = 'content-ratings.cards';

    public function blockSchema(): array
    {
        return [
            Toggle::make('block.dark')
                ->label('My block uses a dark background')
                ->helperText('This will ensure that the colors of each rating will be better tuned to the background'),
        ];
    }
}
