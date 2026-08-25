<?php

declare(strict_types=1);

namespace Nova\Setup\Actions\Migration;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Forms\Models\Form;
use Nova\Setup\Livewire\Concerns\HandlesDates;
use Nova\Setup\Livewire\Concerns\HandlesFormFields;
use Nova\Setup\Livewire\Concerns\HandlesNewIds;
use Nova\Setup\Models\Upgrade;
use stdClass;

/**
 * @phpstan-type LegacyCharacterFormField object{
 *     field_id: int,
 *     field_name: string,
 *     field_label_page: string,
 *     field_help: string|null,
 *     field_type: string,
 *     field_order: int,
 *     field_rows: int|string|null
 * }
 */
class MigrateForm
{
    use AsAction;
    use HandlesDates;
    use HandlesFormFields;
    use HandlesNewIds;

    public int $jobTimeout = 300;

    public function handle(): void
    {
        DB::transaction(function (): void {
            $form = $this->getCharacterBioForm();

            $form->submissions->each(function ($submission): void {
                $submission = $submission->loadMissing('responses');

                $submission->responses->each->delete();
            });

            $form->submissions()->delete();

            $form->formFields()->delete();

            $form->update(['fields' => []]);

            $fields = [];

            DB::connection('nova2')
                ->table('characters_tabs')
                ->orderBy('tab_order', 'asc')
                ->get()
                ->each(function ($tab) use (&$fields, $form): void {
                    $fields[] = [
                        'type' => 'content',
                        'data' => [
                            'details' => [
                                'content' => '<h2>'.str_replace(['&amp;'], ['&'], $tab->tab_name).'</h2>',
                            ],
                        ],
                    ];

                    DB::connection('nova2')
                        ->table('characters_sections')
                        ->where('section_tab', $tab->tab_id)
                        ->orderBy('section_order', 'asc')
                        ->get()
                        ->each(function ($section) use (&$fields, $form, $tab): void {
                            $fields[] = [
                                'type' => 'content',
                                'data' => [
                                    'details' => [
                                        'content' => '<h3>'.str_replace(['&amp;'], ['&'], filled($section->section_name) ? $section->section_name : $tab->tab_name).'</h3>',
                                    ],
                                ],
                            ];

                            $legacyFormFields = DB::connection('nova2')
                                ->table('characters_fields')
                                ->where('field_section', $section->section_id)
                                ->orderBy('field_order', 'asc')
                                ->get()
                                ->map(fn (stdClass $field) => (object) [
                                    'field_id' => (int) $field->field_id,
                                    'field_name' => (string) $field->field_name,
                                    'field_label_page' => (string) $field->field_label_page,
                                    'field_help' => is_string($field->field_help) ? $field->field_help : null,
                                    'field_type' => (string) $field->field_type,
                                    'field_order' => (int) $field->field_order,
                                    'field_rows' => is_int($field->field_rows) || is_string($field->field_rows)
                                        ? $field->field_rows
                                        : null,
                                ]);

                            $legacyFormFields
                                ->each(function ($field) use (&$fields, $form): void {
                                    $fieldUid = Str::random(12);

                                    $formFieldId = DB::table('form_fields')->insertGetId([
                                        'form_id' => $form->id,
                                        'uid' => $fieldUid,
                                        'name' => $field->field_name,
                                        'label' => str_replace(['&amp;'], ['&'], $field->field_label_page),
                                        'type' => $fieldType = match ($field->field_type) {
                                            'select' => 'field-dropdown',
                                            'textarea' => 'field-long-text',
                                            default => 'field-short-text',
                                        },
                                        'order_column' => $field->field_order,
                                        'created_at' => $created = now('UTC'),
                                        'updated_at' => $created,
                                    ]);

                                    if ($fieldType === 'field-dropdown') {
                                        $options = DB::connection('nova2')
                                            ->table('characters_values')
                                            ->where('value_field', $field->field_id)
                                            ->orderBy('value_order', 'asc')
                                            ->get()
                                            ->flatMap(fn ($value): array => [$value->value_field_value => $value->value_content])
                                            ->toArray();
                                    }

                                    $fields[] = match ($fieldType) {
                                        'field-dropdown' => $this->buildDropdownFieldJson($field, $fieldUid, $options),
                                        'field-long-text' => $this->buildLongTextFieldJson($field, $fieldUid),
                                        default => $this->buildShortTextFieldJson($field, $fieldUid),
                                    };

                                    DB::connection('nova2')
                                        ->table('characters_data')
                                        ->join('characters', 'characters_data.data_char', '=', 'characters.charid')
                                        ->where('data_field', $field->field_id)
                                        ->get()
                                        ->each(function ($data) use ($form, $fieldType, $fieldUid): void {
                                            $newCharacterId = $this->getNewId(
                                                id: $data->data_char,
                                                collection: null,
                                                upgradeKey: 'character'
                                            );

                                            $characterFormSubmission = $this->getCharacterFormSubmission(
                                                characterId: $newCharacterId,
                                                formId: $form->id
                                            );

                                            $responseId = DB::table('form_submission_responses')->insertGetId([
                                                'submission_id' => $characterFormSubmission->id,
                                                'field_type' => $fieldType,
                                                'field_uid' => $fieldUid,
                                                'value' => $data->data_value,
                                            ]);

                                            Upgrade::firstOrCreate([
                                                'type' => 'character-form-field-data',
                                                'old_id' => $data->data_id,
                                                'new_id' => $responseId,
                                            ]);
                                        });
                                });
                        });
                });

            $form->update([
                'fields' => $fields,
                'published_fields' => $fields,
                'published_at' => now('UTC'),
            ]);
        });
    }

    public function asJob(): void
    {
        $this->handle();
    }

    protected function getCharacterBioForm(): Form
    {
        return Form::key('characterBio')->first();
    }

    protected function getCharacterFormSubmission(int $characterId, int $formId): object
    {
        $characterSubmission = DB::table('form_submissions')
            ->where('form_id', $formId)
            ->where('owner_type', 'character')
            ->where('owner_id', $characterId)
            ->first();

        if (! $characterSubmission) {
            $characterSubmissionId = DB::table('form_submissions')->insertGetId([
                'form_id' => $formId,
                'owner_type' => 'character',
                'owner_id' => $characterId,
            ]);

            $characterSubmission = DB::table('form_submissions')->find($characterSubmissionId);
        }

        return $characterSubmission;
    }
}
