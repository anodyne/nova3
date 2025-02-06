<?php

declare(strict_types=1);

namespace Nova\Settings\Data;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Nova\Foundation\Rules\Boolean;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class General extends Data implements Arrayable
{
    public function __construct(
        #[MapInputName('game_name')]
        public string $gameName,

        public bool $contactFormEnabled,

        #[MapInputName('contact_form_disabled_message')]
        public ?string $contactFormDisabledMessage
    ) {}

    public static function rules(ValidationContext $context): array
    {
        return [
            'contactFormEnabled' => new Boolean,
        ];
    }

    public static function fromRequest(Request $request): static
    {
        return new self(
            gameName: $request->input('game_name'),
            contactFormEnabled: $request->boolean('contactFormEnabled', true),
            contactFormDisabledMessage: $request->input('contact_form_disabled_message')
        );
    }
}
