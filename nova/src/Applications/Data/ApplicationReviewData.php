<?php

declare(strict_types=1);

namespace Nova\Applications\Data;

use Bag\Bag;
use Nova\Applications\Enums\ApplicationResult;

/**
 * @method static static from(ApplicationResult $result, ?string $comments)
 */
readonly class ApplicationReviewData extends Bag
{
    public function __construct(
        public ApplicationResult $result,
        public ?string $comments
    ) {}
}
