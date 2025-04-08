<?php

declare(strict_types=1);

namespace Nova\Users\Data;

use Bag\Attributes\StripExtraParameters;
use Bag\Attributes\Transforms;
use Bag\Bag;
use Illuminate\Http\Request;

/**
 * @method static static from(string $name, string $email, PronounsData $pronouns)
 */
#[StripExtraParameters]
readonly class UserData extends Bag
{
    public function __construct(
        public string $name,
        public string $email,
        public PronounsData $pronouns,
        public UserModerations $moderations
    ) {}

    #[Transforms(Request::class)]
    protected static function fromRequest(Request $request): array
    {
        return [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'pronouns' => PronounsData::from($request),
            'moderations' => UserModerations::from($request),
        ];
    }
}
