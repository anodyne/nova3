<?php

declare(strict_types=1);

namespace Nova\Announcements\Data;

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Auth;
use Nova\Foundation\Rules\Boolean;
use Nova\Users\Models\User;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class AnnouncementData extends Data
{
    public function __construct(
        public string $title,
        public ?string $category,
        public bool $published,

        #[MapInputName('editor-content')]
        public ?string $content
    ) {}

    public function user(): User
    {
        return Auth::user();
    }

    public static function rules(ValidationContext $context): array
    {
        return [
            'published' => new Boolean,
        ];
    }

    public static function fromRequest(Request $request): static
    {
        return new self(
            title: $request->input('title'),
            category: $request->input('category'),
            published: $request->boolean('published', true),
            content: $request->input('editor-content')
        );
    }
}
