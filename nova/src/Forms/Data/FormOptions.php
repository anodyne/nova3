<?php

declare(strict_types=1);

namespace Nova\Forms\Data;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Arr;
use Nova\Foundation\Rules\Boolean;
use Spatie\LaravelData\Data;

class FormOptions extends Data implements Arrayable
{
    public function __construct(
        public bool $onlyAuthenticatedUsers,
        public bool $collectResponses,
        public bool $singleSubmission,
        public ?string $submissionTitleField,
        public bool $emailResponses,
        public ?string $emailRecipients = null
    ) {}

    public static function fromArray(array $data): static
    {
        return new self(
            onlyAuthenticatedUsers: Arr::boolean($data, 'onlyAuthenticatedUsers'),
            collectResponses: Arr::boolean($data, 'collectResponses'),
            singleSubmission: Arr::boolean($data, 'singleSubmission'),
            submissionTitleField: data_get($data, 'submissionTitleField'),
            emailResponses: Arr::boolean($data, 'emailResponses'),
            emailRecipients: data_get($data, 'emailRecipients'),
        );
    }

    public static function rules(): array
    {
        return [
            'onlyAuthenticatedUsers' => [new Boolean()],
            'collectResponses' => [new Boolean()],
            'singleSubmission' => [new Boolean()],
            'submissionTitleField' => ['nullable'],
            'emailResponses' => [new Boolean()],
            'emailRecipients' => ['nullable'],
        ];
    }

    public function getEmailRecipients(): array
    {
        if (blank($this->emailRecipients)) {
            return [];
        }

        return array_map('trim', explode(',', $this->emailRecipients));
    }
}
