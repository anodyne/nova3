<?php

declare(strict_types=1);

namespace Nova\Applications\Data;

use Bag\Bag;
use Nova\Applications\Enums\ApplicationResult;

/**
 * @method static static from(ApplicationResult $result, ?string $comments)
 *
 * @phpstan-method static static from(mixed ...$values)
 */
readonly class ApplicationReviewData extends Bag
{
    public function __construct(
        public ApplicationResult $result,
        public ?string $comments
    ) {}
}
