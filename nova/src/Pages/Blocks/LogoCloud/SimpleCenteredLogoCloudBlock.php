<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\LogoCloud;

class SimpleCenteredLogoCloudBlock extends LogoCloudBlock
{
    public ?string $label = 'Logos - Simple centered';

    public string $rendered = 'pages.pages.blocks.logo-cloud.simple-centered';

    public string $preview = 'pages.pages.blocks.logo-cloud.simple-centered-preview';

    public bool $useDescription = false;
}
