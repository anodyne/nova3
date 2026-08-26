<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        DB::transaction(function () {
            $now = Date::now();

            $forms = [
                'characterBio' => [
                    'name' => 'Character bio',
                    'key' => 'characterBio',
                    'type' => 'advanced',
                    'is_locked' => true,
                    'fields' => [
                        ['type' => 'content',  'data' => ['details' => ['content' => '<h2>Physical characteristics</h2>']]],
                        ['type' => 'dropdown', 'data' => [
                            'details' => ['label' => 'Gender', 'description' => null, 'required' => false, 'hideWhenEmpty' => false],
                            'attrs' => ['name' => 'gender', 'id' => 'q1KFAGgD2qmY', 'placeholder' => null, 'options' => ['Male' => 'Male', 'Female' => 'Female', 'Other' => 'Other'], 'other' => []],
                        ]],
                    ],
                    'published_fields' => [ // same as fields for this one
                        ['type' => 'content',  'data' => ['details' => ['content' => '<h2>Physical characteristics</h2>']]],
                        ['type' => 'dropdown', 'data' => [
                            'details' => ['label' => 'Gender', 'description' => null, 'required' => false, 'hideWhenEmpty' => false],
                            'attrs' => ['name' => 'gender', 'id' => 'q1KFAGgD2qmY', 'placeholder' => null, 'options' => ['Male' => 'Male', 'Female' => 'Female', 'Other' => 'Other'], 'other' => []],
                        ]],
                    ],
                    'published_at' => $now,
                ],

                'userBio' => [
                    'name' => 'User bio',
                    'key' => 'userBio',
                    'type' => 'advanced',
                    'is_locked' => true,
                    'fields' => null,
                    'published_fields' => null,
                    'published_at' => null,
                ],

                'applicationInfo' => [
                    'name' => 'Application info',
                    'key' => 'applicationInfo',
                    'type' => 'advanced',
                    'is_locked' => true,
                    'fields' => [
                        ['type' => 'dropdown', 'data' => [
                            'details' => ['label' => 'Where did you hear about us?', 'description' => null, 'required' => false, 'hideWhenEmpty' => false],
                            'attrs' => ['name' => 'where-did-you-hear-about-us', 'id' => '0PEnRFoCzY5p', 'placeholder' => null, 'options' => ['Fleet page' => 'Fleet page', 'Recruitment server' => 'Recruitment server', 'Other' => 'Other'], 'other' => []],
                        ]],
                    ],
                    'published_fields' => [
                        ['type' => 'dropdown', 'data' => [
                            'details' => ['label' => 'Where did you hear about us?', 'description' => null, 'required' => false, 'hideWhenEmpty' => false],
                            'attrs' => ['name' => 'where-did-you-hear-about-us', 'id' => '0PEnRFoCzY5p', 'placeholder' => null, 'options' => ['Fleet page' => 'Fleet page', 'Recruitment server' => 'Recruitment server', 'Other' => 'Other'], 'other' => []],
                        ]],
                    ],
                    'published_at' => $now,
                ],

                'applicationReview' => [
                    'name' => 'Application review',
                    'key' => 'applicationReview',
                    'type' => 'advanced',
                    'is_locked' => true,
                    'fields' => [
                        ['type' => 'dropdown', 'data' => [
                            'details' => ['label' => 'How interested are you in this application?', 'description' => null, 'required' => false, 'hideWhenEmpty' => false],
                            'attrs' => [
                                'name' => 'how-interested-are-you-in-this-application', 'id' => 'KDlNCVuXvgVA', 'placeholder' => null,
                                'options' => [
                                    'Not at all' => '1- Not at all',
                                    'Not really' => '2 - Not really',
                                    'Neutral' => '3 - Neutral',
                                    'Interested' => '4 - Interested',
                                    'Very interested' => '5 - Very interested',
                                ],
                                'other' => [],
                            ],
                        ]],
                    ],
                    'published_fields' => [
                        ['type' => 'dropdown', 'data' => [
                            'details' => ['label' => 'How interested are you in this application?', 'description' => null, 'required' => false, 'hideWhenEmpty' => false],
                            'attrs' => [
                                'name' => 'how-interested-are-you-in-this-application', 'id' => 'KDlNCVuXvgVA', 'placeholder' => null,
                                'options' => [
                                    'Not at all' => '1- Not at all',
                                    'Not really' => '2 - Not really',
                                    'Neutral' => '3 - Neutral',
                                    'Interested' => '4 - Interested',
                                    'Very interested' => '5 - Very interested',
                                ],
                                'other' => [],
                            ],
                        ]],
                    ],
                    'published_at' => $now,
                ],
            ];

            $jsonColumns = ['fields', 'published_fields'];

            $template = [
                'name' => null,
                'key' => null,
                'type' => null,
                'is_locked' => null,
                'fields' => null, // JSON string
                'published_fields' => null, // JSON string
                'published_at' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ];

            $formRows = [];
            foreach ($forms as $form) {
                foreach ($jsonColumns as $column) {
                    if (array_key_exists($column, $form) && is_array($form[$column])) {
                        $form[$column] = json_encode($form[$column], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                    }
                }
                $formRows[] = array_replace($template, $form, ['id' => Str::uuid7()->toString(), 'created_at' => $now, 'updated_at' => $now]);
            }

            DB::table('forms')->upsert(
                $formRows,
                ['key'],
                ['name', 'type', 'is_locked', 'fields', 'published_fields', 'published_at', 'updated_at']
            );

            $idsByKey = DB::table('forms')
                ->whereIn('key', array_keys($forms))
                ->pluck('id', 'key');

            $formFieldRows = [];
            foreach ($forms as $key => $form) {
                $formId = $idsByKey[$key] ?? null;

                if (! is_array($form['published_fields'])) {
                    continue;
                }

                foreach ($form['published_fields'] as $index => $field) {
                    if ($field['type'] === 'content') {
                        continue;
                    }

                    $uid = data_get($field, 'data.attrs.id');
                    if (! $uid) {
                        continue;
                    }

                    $formFieldRows[] = [
                        'id' => Str::uuid7()->toString(),
                        'uid' => $uid,
                        'form_id' => $formId,
                        'name' => data_get($field, 'data.attrs.name'),
                        'label' => data_get($field, 'data.details.label'),
                        'type' => data_get($field, 'type'),
                        'order_column' => $index,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                }
            }

            if ($formFieldRows) {
                DB::table('form_fields')->upsert(
                    $formFieldRows,
                    ['uid'],
                    ['form_id', 'name', 'label', 'type', 'order_column', 'updated_at']
                );
            }
        });
    }

    public function down(): void
    {
        DB::table('form_fields')->truncate();
        DB::table('forms')->truncate();
    }
};
