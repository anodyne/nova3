<?php

declare(strict_types=1);

namespace Nova\Settings\Data;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Spatie\LaravelData\Data;

class ApplicationReviewers extends Data implements Arrayable
{
    public function __construct(
        public array $globalReviewers = []
    ) {}

    public static function fromRequest(Request $request): static
    {
        return new self(
            globalReviewers: explode(',', $request->input('global_reviewers', ''))
        );
    }
}
