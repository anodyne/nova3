<?php

declare(strict_types=1);

namespace Nova\Pages\Data;

use Nova\Pages\Enums\PageVerb;
use Spatie\LaravelData\Data;

class PageData extends Data
{
    public function __construct(
        public string $name,

        public string $key,

        public string $uri,

        public PageVerb $verb,

        public ?string $resource,

        public string $layout
    ) {}
}
