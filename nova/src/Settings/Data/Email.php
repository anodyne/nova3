<?php

declare(strict_types=1);

namespace Nova\Settings\Data;

use Illuminate\Contracts\Support\Arrayable;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;

class Email extends Data implements Arrayable
{
    public function __construct(
        #[MapInputName('subject_prefix')]
        public ?string $subjectPrefix,

        #[MapInputName('reply_to')]
        public ?string $replyTo,

        #[MapInputName('image_path')]
        public ?string $imagePath
    ) {
    }
}
