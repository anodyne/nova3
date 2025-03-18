<?php

declare(strict_types=1);

namespace Nova\Setup\Actions\Migration;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Forms\Actions\SyncDatabaseFormFields;
use Nova\Forms\Models\Form;
use Nova\Setup\Livewire\Concerns\HandlesDates;
use Nova\Setup\Livewire\Concerns\HandlesFormFields;
use Nova\Setup\Livewire\Concerns\HandlesNewIds;

class MigrateLegacyUserData
{
    use AsAction;
    use HandlesDates;
    use HandlesFormFields;
    use HandlesNewIds;

    public function handle(): void
    {
        DB::transaction(function () {
            $form = $this->getUserBioForm();

            $form->submissions->each(fn ($submission) => $submission->load('responses')->responses->each->delete());

            $form->submissions()->delete();

            $form->formFields()->delete();

            $form->update(['fields' => []]);

            $fields = [
                'type' => 'doc',
                'content' => [],
            ];

            $fields['content'][] = $this->createShortTextFieldJson(label: 'Date of birth', name: 'date_of_birth');
            $fields['content'][] = $this->createLongTextFieldJson(label: 'Instant messengers', name: 'instant_message');
            $fields['content'][] = $this->createShortTextFieldJson(label: 'Location', name: 'location');
            $fields['content'][] = $this->createLongTextFieldJson(label: 'Interests', name: 'interests');
            $fields['content'][] = $this->createLongTextFieldJson(label: 'Bio', name: 'bio');

            $form->update([
                'fields' => $fields,
                'published_fields' => $fields,
                'published_at' => now('UTC'),
            ]);

            SyncDatabaseFormFields::run($form);

            $formFields = DB::table('form_fields')->where('form_id', $form->id)->get();

            DB::connection('nova2')
                ->table('users')
                ->get()
                ->each(function ($user) use ($form, $formFields) {
                    $newUserId = $this->getNewId(
                        id: $user->userid,
                        collection: null,
                        upgradeKey: 'user'
                    );

                    $userFormSubmission = $this->getUserFormSubmission(
                        userId: $newUserId,
                        formId: $form->id
                    );

                    $newFields = [
                        'date_of_birth' => $user->date_of_birth,
                        'instant_message' => $user->instant_message,
                        'location' => $user->location,
                        'interests' => $user->interests,
                        'bio' => $user->bio,
                    ];

                    foreach ($newFields as $fieldName => $value) {
                        $field = $formFields->where('name', $fieldName)->first();

                        DB::table('form_submission_responses')->insert([
                            'submission_id' => $userFormSubmission->id,
                            'field_type' => $field->type,
                            'field_uid' => $field->uid,
                            'value' => $value,
                        ]);
                    }
                });
        });
    }

    public function asJob(): void
    {
        $this->handle();
    }

    protected function getUserBioForm(): Form
    {
        return Form::key('userBio')->first();
    }

    protected function getUserFormSubmission(int $userId, int $formId): object
    {
        $submission = DB::table('form_submissions')
            ->where('form_id', $formId)
            ->where('owner_type', 'user')
            ->where('owner_id', $userId)
            ->first();

        if (! $submission) {
            $submissionId = DB::table('form_submissions')->insertGetId([
                'form_id' => $formId,
                'owner_type' => 'user',
                'owner_id' => $userId,
            ]);

            $submission = DB::table('form_submissions')->find($submissionId);
        }

        return $submission;
    }
}
