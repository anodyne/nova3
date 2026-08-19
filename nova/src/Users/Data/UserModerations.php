<?php

declare(strict_types=1);

namespace Nova\Users\Data;

use Bag\Attributes\StripExtraParameters;
use Bag\Attributes\Transforms;
use Bag\Bag;
use Illuminate\Http\Request;

/**
 * @method static static from(bool $announcements, bool $posts)
 *
 * @phpstan-method static static from(mixed ...$values)
 */
#[StripExtraParameters]
readonly class UserModerations extends Bag
{
    public function __construct(
        public bool $announcements,
        public bool $posts
    ) {}

    public function isModerated(): bool
    {
        return $this->announcements || $this->posts;
    }

    public static function resources(): array
    {
        return ['announcements', 'posts'];
    }

    #[Transforms(Request::class)]
    protected static function fromRequest(Request $request): array
    {
        return [
            'announcements' => $request->boolean('moderations.announcements', false),
            'posts' => $request->boolean('moderations.posts', false),
        ];
    }
}
