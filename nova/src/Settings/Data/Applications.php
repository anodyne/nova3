<?php

declare(strict_types=1);

namespace Nova\Settings\Data;

use Bag\Attributes\Transforms;
use Bag\Bag;
use Illuminate\Http\Request;

/**
 * @method static static from(bool $enabled, ?string $disabledMessage, bool $alwaysShowResults, bool $allowVoteChanging, bool $showDecisionMessage)
 */
readonly class Applications extends Bag
{
    public function __construct(
        public bool $enabled,
        public ?string $disabledMessage,
        public bool $alwaysShowResults,
        public bool $allowVoteChanging,
        public bool $showDecisionMessage
    ) {}

    #[Transforms(Request::class)]
    protected static function fromRequest(Request $request): array
    {
        return [
            'enabled' => $request->boolean('enabled', true),
            'disabledMessage' => $request->input('disabled_message'),
            'alwaysShowResults' => $request->boolean('alwaysShowResults', false),
            'allowVoteChanging' => $request->boolean('allowVoteChanging', false),
            'showDecisionMessage' => $request->boolean('showDecisionMessage', true),
        ];
    }
}
