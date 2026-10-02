<?php

declare(strict_types=1);

namespace Nova\Forms\Actions;

use Nova\Forms\Models\FormField;
use Nova\Forms\Models\FormSubmission;
use Nova\Foundation\Actions\Action;

class SyncFormSubmissionResponses extends Action
{
    /**
     * @param  array<string, mixed>  $values  Field UID to submitted value.
     */
    public function handle(FormSubmission $submission, array $values = []): FormSubmission
    {
        $data = collect($values)
            ->map(function ($value, $uid): array {
                $field = FormField::uid($uid)->first();

                return [
                    'field_type' => $field->type,
                    'field_uid' => $uid,
                    'value' => $value,
                ];
            });

        $submission->responses()->createUpdateOrDelete($data->toArray());

        return $submission->refresh();
    }
}
