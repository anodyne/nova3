<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\CallToAction;

class SplitCallToActionBlock extends CallToActionBlock
{
    public ?string $label = 'CTA - Split';

    public string $rendered = 'pages.pages.blocks.call-to-action.split';

    public string $preview = 'pages.pages.blocks.call-to-action.split-preview';
}
