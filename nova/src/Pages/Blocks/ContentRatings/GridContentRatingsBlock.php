<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\ContentRatings;

use Closure;
use Filament\Forms\Components\Toggle;

class GridContentRatingsBlock extends ContentRatingsBlock
{
    const component = 'content-ratings.grid';

    protected ?string $blockLabel = 'Content ratings - Grid';

    protected string|Closure|null $preview = 'content-ratings.grid';

    public function blockSchema(): array
    {
        return [
            Toggle::make('block.dark')
                ->label('My block uses a dark background')
                ->helperText('This will ensure that the colors of each rating will be better tuned to the background'),
        ];
    }
}
