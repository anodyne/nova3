<?php

declare(strict_types=1);

namespace Nova\Settings\Data;

use Bag\Attributes\Transforms;
use Bag\Bag;
use Illuminate\Http\Request;

/**
 * @method static static from(list<int|string> $globalReviewers)
 *
 * @phpstan-method static static from(mixed ...$values)
 */
readonly class ApplicationReviewers extends Bag
{
    /** @param list<int|string> $globalReviewers */
    public function __construct(
        public array $globalReviewers = []
    ) {}

    /** @return array{globalReviewers: list<string>} */
    #[Transforms(Request::class)]
    protected static function fromRequest(Request $request): array
    {
        return [
            'globalReviewers' => explode(',', $request->input('global_reviewers', '') ?? ''),
        ];
    }
}
