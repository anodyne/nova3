<?php

declare(strict_types=1);

namespace Nova\Forms\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Forms\Models\FormField;
use Nova\Forms\Models\FormSubmission;

class SyncFormSubmissionResponses
{
    use AsAction;

    public function handle(FormSubmission $submission, array $values = []): FormSubmission
    {
        $data = collect($values)->map(function ($value, $uid): array {
            $field = FormField::uid($uid)->first();

            return [
                'field_type' => $field->type,
                'field_uid' => $uid,
                'value' => $value,
            ];
        });

        $submission->responses()->createUpdateOrDelete($data->all());

        return $submission->refresh();
    }
}
