<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\LogoCloud;

class SplitLogoCloudBlock extends LogoCloudBlock
{
    public ?string $label = 'Logos - Split';

    public string $rendered = 'pages.pages.blocks.logo-cloud.split';

    public string $preview = 'pages.pages.blocks.logo-cloud.split-preview';

    public bool $useDescription = true;
}
