<?php

declare(strict_types=1);

namespace Nova\Settings\Data;

use Bag\Attributes\MapInputName;
use Bag\Attributes\StripExtraParameters;
use Bag\Bag;
use Bag\Mappers\SnakeCase;

/**
 * @method static static from(?string $subjectPrefix, ?string $replyTo, ?string $imagePath)
 */
#[MapInputName(SnakeCase::class)]
#[StripExtraParameters]
readonly class Email extends Bag
{
    public function __construct(
        public ?string $subjectPrefix,
        public ?string $replyTo,
        public ?string $imagePath
    ) {}
}
