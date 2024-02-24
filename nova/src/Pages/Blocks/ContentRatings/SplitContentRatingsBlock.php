<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\ContentRatings;

class SplitContentRatingsBlock extends ContentRatingsBlock
{
    public ?string $label = 'Content ratings - Split';

    public string $rendered = 'pages.pages.blocks.content-ratings.split';

    public string $preview = 'pages.pages.blocks.content-ratings.split';
}
