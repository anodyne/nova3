<?php

declare(strict_types=1);

namespace Nova\Settings\Data;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Nova\Foundation\Rules\Boolean;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class Applications extends Data implements Arrayable
{
    public function __construct(
        public bool $enabled,
        public ?string $disabledMessage,
        public bool $alwaysShowResults,
        public bool $allowVoteChanging,
        public bool $showDecisionMessage
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'enabled' => new Boolean,
            'alwaysShowResults' => new Boolean,
            'allowVoteChanging' => new Boolean,
            'showDecisionMessage' => new Boolean,
        ];
    }

    public static function fromRequest(Request $request): static
    {
        return new self(
            enabled: $request->boolean('enabled', true),
            disabledMessage: $request->input('disabled_message'),
            alwaysShowResults: $request->boolean('alwaysShowResults', false),
            allowVoteChanging: $request->boolean('allowVoteChanging', false),
            showDecisionMessage: $request->boolean('showDecisionMessage', true)
        );
    }
}
