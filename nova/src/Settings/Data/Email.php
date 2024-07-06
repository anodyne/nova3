<?php

declare(strict_types=1);

namespace Nova\Settings\Data;

use Illuminate\Contracts\Support\Arrayable;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Mappers\SnakeCaseMapper;

#[MapInputName(SnakeCaseMapper::class)]
class Email extends Data implements Arrayable
{
    public function __construct(
        public ?string $subjectPrefix,
        public ?string $replyTo,
        public ?string $imagePath
    ) {}
}
