<?php

declare(strict_types=1);

namespace Nova\Pages\Blocks\Logos;

use Closure;

class SplitLogosBlock extends LogosBlock
{
    const component = 'logos.split';

    protected ?string $blockLabel = 'Logos - Split';

    protected string|Closure|null $preview = 'logos.split';
}
