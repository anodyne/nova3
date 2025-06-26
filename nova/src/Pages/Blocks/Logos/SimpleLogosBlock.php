<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Logos;

use Closure;

class SimpleLogosBlock extends LogosBlock
{
    const component = 'logos.simple';

    protected ?string $blockLabel = 'Logos - Simple';

    protected string|Closure|null $preview = 'logos.simple';
}
