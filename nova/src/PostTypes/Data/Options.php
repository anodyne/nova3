<?php

declare(strict_types=1);

namespace Nova\PostTypes\Data;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
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

    public static function fromArray(array $array): static
    {
        return new self(
            notifiesUsers: Arr::boolean($array, 'notifiesUsers'),
            includedInPostTracking: Arr::boolean($array, 'includedInPostTracking'),
            allowsMultipleAuthors: Arr::boolean($array, 'allowsMultipleAuthors'),
            allowsCharacterAuthors: Arr::boolean($array, 'allowsCharacterAuthors'),
            allowsUserAuthors: Arr::boolean($array, 'allowsUserAuthors'),
        );
    }

    public static function fromRequest(Request $request): static
    {
        return new self(
            notifiesUsers: $request->boolean('notifiesUsers'),
            includedInPostTracking: $request->boolean('includedInPostTracking'),
            allowsMultipleAuthors: $request->boolean('allowsMultipleAuthors'),
            allowsCharacterAuthors: $request->boolean('allowsCharacterAuthors'),
            allowsUserAuthors: $request->boolean('allowsUserAuthors'),
        );
    }
}
