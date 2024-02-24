<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\ContentRatings;

class CardContentRatingsBlock extends ContentRatingsBlock
{
    public ?string $label = 'Content ratings - Cards';

    public string $rendered = 'pages.pages.blocks.content-ratings.cards';

    public string $preview = 'pages.pages.blocks.content-ratings.cards';
}
