<?php

declare(strict_types=1);

namespace Nova\Settings\Data;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Spatie\LaravelData\Data;

class Ratings extends Data implements Arrayable
{
    public function __construct(
        public string $theme = 'pulsar',
        public string $iconSet = 'fluent',
    ) {
    }

    public static function fromRequest(Request $request): static
    {
        return new self(
            iconSet: $request->input('icon-set', 'fluent'),
            theme: $request->input('theme', 'pulsar')
        );
    }
}
