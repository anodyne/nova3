<?php

declare(strict_types=1);

namespace Nova\Settings\Data;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Spatie\LaravelData\Data;

class ContentRatings extends Data implements Arrayable
{
    public function __construct(
        public ?ContentRating $language,
        public ?ContentRating $sex,
        public ?ContentRating $violence,
    ) {
    }

    public static function fromRequest(Request $request): static
    {
        return new self(
            language: ContentRating::from($request->get('language', settings('ratings.language'))),
            sex: ContentRating::from($request->get('sex', settings('ratings.sex'))),
            violence: ContentRating::from($request->get('violence', settings('ratings.violence'))),
        );
    }
}
