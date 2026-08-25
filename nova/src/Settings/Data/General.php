<?php

declare(strict_types=1);

namespace Nova\Settings\Data;

use Bag\Attributes\MapInputName;
use Bag\Attributes\Transforms;
use Bag\Bag;
use Bag\Mappers\SnakeCase;
use Illuminate\Http\Request;

/**
 * @method static static from(string $gameName, bool $contactFormEnabled, ?string $contactFormDisabledMessage)
 *
 * @phpstan-method static static from(mixed ...$values)
 */
readonly class General extends Bag
{
    public function __construct(
        #[MapInputName(SnakeCase::class)]
        public string $gameName,

        public bool $contactFormEnabled,

        #[MapInputName(SnakeCase::class)]
        public ?string $contactFormDisabledMessage
    ) {}

    /**
     * @return array{
     *     gameName: mixed,
     *     contactFormEnabled: bool,
     *     contactFormDisabledMessage: mixed
     * }
     */
    #[Transforms(Request::class)]
    protected static function fromRequest(Request $request): array
    {
        return [
            'gameName' => $request->input('game_name'),
            'contactFormEnabled' => $request->boolean('contactFormEnabled'),
            'contactFormDisabledMessage' => $request->input('contact_form_disabled_message'),
        ];
    }
}
