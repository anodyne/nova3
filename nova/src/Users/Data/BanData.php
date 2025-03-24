<?php

declare(strict_types=1);

namespace Nova\Users\Data;

use Bag\Attributes\Transforms;
use Bag\Bag;
use Carbon\CarbonInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Nova\Users\Models\User;

/**
 * @method static static from(?string $bannable_type, ?string $bannable_id, ?string $ip, ?string $comment, ?CarbonInterface $expired_at)
 */
readonly class BanData extends Bag
{
    public function __construct(
        public ?string $bannable_type,
        public ?string $bannable_id,
        public ?string $ip,
        public ?string $comment,
        public ?CarbonInterface $expired_at
    ) {}

    public function user(): ?User
    {
        return User::find($this->bannable_id);
    }

    #[Transforms(Request::class)]
    protected static function fromRequest(Request $request): array
    {
        return [
            'bannable_type' => $request->has('bannable_id') ? 'user' : null,
            'bannable_id' => $request->input('bannable_id'),
            'ip' => $request->input('ip'),
            'comment' => $request->input('comment'),
            'expired_at' => filled($request->input('expired_at')) ? Date::parse($request->input('expired_at')) : null,
        ];
    }
}
