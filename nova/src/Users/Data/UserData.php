<?php

declare(strict_types=1);

namespace Nova\Users\Data;

use Illuminate\Http\Request;
use Spatie\LaravelData\Data;

class UserData extends Data
{
    public function __construct(
        public string $name,
        public string $email,
        public PronounsData $pronouns
    ) {}

    public static function fromRequest(Request $request): static
    {
        return new self(
            name: $request->input('name'),
            email: $request->input('email'),
            pronouns: PronounsData::from($request->input('pronouns', []))
        );
    }
}
