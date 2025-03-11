<?php

declare(strict_types=1);

namespace Nova\Stories\Data;

use Bag\Attributes\Transforms;
use Bag\Bag;

/**
 * @method static static from(string $status)
 */
readonly class PostStatusData extends Bag
{
    public function __construct(
        public string $status
    ) {}

    #[Transforms('string')]
    protected static function fromJsonString(string $json): mixed
    {
        return [
            'status' => $json,
        ];
    }
}
