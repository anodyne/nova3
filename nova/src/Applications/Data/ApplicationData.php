<?php

declare(strict_types=1);

namespace Nova\Applications\Data;

use Bag\Attributes\Transforms;
use Bag\Bag;
use Illuminate\Http\Request;
use Nova\Characters\Models\Character;
use Nova\Users\Models\User;

readonly class ApplicationData extends Bag
{
    public function __construct(
        public ?int $character_id,
        public ?int $user_id,
        public ?string $ip_address
    ) {}

    public function character(): ?Character
    {
        return Character::find($this->character_id);
    }

    public function user(): ?User
    {
        return User::find($this->user_id);
    }

    #[Transforms(Request::class)]
    protected static function fromRequest(Request $request): array
    {
        return [
            'character_id' => $request->input('character_id'),
            'user_id' => $request->input('user_id'),
            'ip_address' => $request->input('ip_address'),
        ];
    }
}
