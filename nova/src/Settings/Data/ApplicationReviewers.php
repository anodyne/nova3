<?php

declare(strict_types=1);

namespace Nova\Settings\Data;

use Bag\Attributes\Transforms;
use Bag\Bag;
use Illuminate\Http\Request;

/**
 * @method static static from(array $globalReviewers)
 *
 * @phpstan-method static static from(mixed ...$values)
 */
readonly class ApplicationReviewers extends Bag
{
    public function __construct(
        public array $globalReviewers = []
    ) {}

    #[Transforms(Request::class)]
    protected static function fromRequest(Request $request): array
    {
        return [
            'globalReviewers' => explode(',', $request->input('global_reviewers', '') ?? ''),
        ];
    }
}
