<?php

declare(strict_types=1);

namespace Nova\PostTypes\Data;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use Nova\Foundation\Rules\Boolean;
use Spatie\LaravelData\Data;

class Options extends Data implements Arrayable
{
    public function __construct(
        public bool $notifiesUsers,
        public bool $includedInPostTracking,
        public bool $allowsMultipleAuthors,
        public bool $allowsCharacterAuthors,
        public bool $allowsUserAuthors,
    ) {
    }

    public static function fromArray(array $data): static
    {
        return new self(
            notifiesUsers: Arr::boolean($data, 'notifiesUsers'),
            includedInPostTracking: Arr::boolean($data, 'includedInPostTracking'),
            allowsMultipleAuthors: Arr::boolean($data, 'allowsMultipleAuthors'),
            allowsCharacterAuthors: Arr::boolean($data, 'allowsCharacterAuthors'),
            allowsUserAuthors: Arr::boolean($data, 'allowsUserAuthors')
        );
    }

    public static function rules(): array
    {
        return [
            'notifiesUsers' => [new Boolean()],
            'includedInPostTracking' => [new Boolean()],
            'allowsMultipleAuthors' => [new Boolean()],
            'allowsCharacterAuthors' => [new Boolean()],
            'allowsUserAuthors' => [new Boolean()],
        ];
    }
}
