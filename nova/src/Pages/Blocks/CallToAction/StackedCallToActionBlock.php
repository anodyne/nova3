<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\CallToAction;

class StackedCallToActionBlock extends CallToActionBlock
{
    public ?string $label = 'CTA - Stacked';

    public string $rendered = 'pages.pages.blocks.call-to-action.stacked';

    public string $preview = 'pages.pages.blocks.call-to-action.stacked-preview';
}
