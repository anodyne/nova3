<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\ContentRatings;

class GridContentRatingsBlock extends ContentRatingsBlock
{
    public ?string $label = 'Content ratings - Grid';

    public string $rendered = 'pages.pages.blocks.content-ratings.grid';

    public string $preview = 'pages.pages.blocks.content-ratings.grid';
}
