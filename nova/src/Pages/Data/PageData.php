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

        public string $layout,

        public ?string $seo_title,

        public ?string $seo_description,

        public ?string $seo_keywords,

        public ?string $heading,

        public ?string $subheading,

        public ?string $intro,
    ) {}
}
