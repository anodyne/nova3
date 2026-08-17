<?php

declare(strict_types=1);

namespace Nova\Announcements\Data;

use Bag\Attributes\Transforms;
use Bag\Bag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Nova\Foundation\Enums\PublishStatus;
use Nova\Users\Models\User;

/**
 * @method static static from(string $title, ?string $category, PublishStatus $status, ?string $content)
 *
 * @phpstan-method static static from(mixed ...$values)
 */
readonly class AnnouncementData extends Bag
{
    public function __construct(
        public string $title,
        public ?string $category,
        public PublishStatus $status,
        public ?string $content
    ) {}

    public function user(): User
    {
        $user = Auth::user();

        if (! $user) {
            throw new \RuntimeException('User must be authenticated to create announcements');
        }

        return $user;
    }

    #[Transforms(Request::class)]
    protected static function fromRequest(Request $request): array
    {
        return [
            'title' => $request->string('title')->value(),
            'category' => $request->string('category')->value(),
            'status' => $request->enum('status', PublishStatus::class),
            'content' => $request->string('content')->value(),
        ];
    }
}
