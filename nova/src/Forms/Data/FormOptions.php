<?php

declare(strict_types=1);

namespace Nova\Forms\Data;

use Bag\Attributes\Transforms;
use Bag\Bag;
use Illuminate\Http\Request;

/**
 * @method static static from(bool $onlyAuthenticatedUsers, bool $collectResponses, bool $singleSubmission, ?string $submissionTitleField, bool $emailResponses, ?string $emailRecipients)
 *
 * @phpstan-method static static from(mixed ...$values)
 */
readonly class FormOptions extends Bag
{
    public function __construct(
        public bool $onlyAuthenticatedUsers,
        public bool $collectResponses,
        public bool $singleSubmission,
        public ?string $submissionTitleField,
        public bool $emailResponses,
        public ?string $emailRecipients = null
    ) {}

    public function getEmailRecipients(): array
    {
        if (blank($this->emailRecipients)) {
            return [];
        }

        return array_map(trim(...), explode(',', $this->emailRecipients ?? ''));
    }

    #[Transforms(Request::class)]
    protected static function fromRequest(Request $request): array
    {
        return [
            'onlyAuthenticatedUsers' => $request->boolean('options.onlyAuthenticatedUsers'),
            'collectResponses' => $request->boolean('options.collectResponses'),
            'singleSubmission' => $request->boolean('options.singleSubmission'),
            'submissionTitleField' => $request->input('options.submissionTitleField'),
            'emailResponses' => $request->boolean('options.emailResponses'),
            'emailRecipients' => $request->input('options.emailRecipients'),
        ];
    }
}
