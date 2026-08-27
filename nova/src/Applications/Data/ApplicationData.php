<?php

declare(strict_types=1);

namespace Nova\Applications\Data;

use Bag\Attributes\Transforms;
use Bag\Bag;
use Illuminate\Http\Request;
use Nova\Characters\Models\Character;
use Nova\Users\Models\User;

/**
 * @method static static from(?string $character_id, ?string $user_id, ?string $ip_address)
 *
 * @phpstan-method static static from(mixed ...$values)
 */
readonly class ApplicationData extends Bag
{
    public function __construct(
        public ?string $character_id,
        public ?string $user_id,
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

    /**
     * @return array{character_id: mixed, user_id: mixed, ip_address: mixed}
     */
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
