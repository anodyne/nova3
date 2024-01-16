<?php

declare(strict_types=1);

namespace Nova\Settings\Data;

use Spatie\LaravelData\Data;

class FontFamilies extends Data
{
    public function __construct(
        public string $headerProvider,
        public string $headerFamily,
        public string $bodyProvider,
        public string $bodyFamily
    ) {
    }
}
