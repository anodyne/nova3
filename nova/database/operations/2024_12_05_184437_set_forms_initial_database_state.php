<?php

declare(strict_types=1);

use Illuminate\Support\Facades\DB;
use Nova\Forms\Actions\PublishFormManager;
use Nova\Forms\Enums\FormType;
use Nova\Forms\Models\Form;
use TimoKoerber\LaravelOneTimeOperations\OneTimeOperation;

return new class extends OneTimeOperation
{
    protected bool $async = false;

    protected string $queue = 'default';

    protected ?string $tag = null;

    public function process(): void
    {
        activity()->disableLogging();

        DB::table('forms')->insert([
            'name' => 'Character bio',
            'key' => 'characterBio',
            'type' => FormType::Advanced,
            'is_locked' => true,
            'fields' => '[{"type":"dropdown","data":{"details":{"label":"Gender","description":null,"required":false,"hideWhenEmpty":false},"attrs":{"name":"gender","id":"q1KFAGgD2qmY","placeholder":null,"options":{"Male":"Male","Female":"Female","Other":"Other"},"other":[]}}}]',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('forms')->insert([
            'name' => 'User bio',
            'key' => 'userBio',
            'type' => FormType::Advanced,
            'is_locked' => true,
            'fields' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('forms')->insert([
            'name' => 'Application info',
            'key' => 'applicationInfo',
            'type' => FormType::Advanced,
            'is_locked' => true,
            'fields' => '[{"type":"dropdown","data":{"details":{"label":"Where did you hear about us?","description":null,"required":false,"hideWhenEmpty":false},"attrs":{"name":"where-did-you-hear-about-us","id":"0PEnRFoCzY5p","placeholder":null,"options":{"Fleet page":"Fleet page","Recruitment server":"Recruitment server","Other":"Other"},"other":[]}}}]',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('forms')->insert([
            'name' => 'Application review',
            'key' => 'applicationReview',
            'type' => FormType::Advanced,
            'is_locked' => true,
            'fields' => '[{"type":"dropdown","data":{"details":{"label":"How interested are you in this application?","description":null,"required":false,"hideWhenEmpty":false},"attrs":{"name":"how-interested-are-you-in-this-application","id":"KDlNCVuXvgVA","placeholder":null,"options":{"Not at all":"1- Not at all","Not really":"2 - Not really","Neutral":"3 - Neutral","Interested":"4 - Interested","Very interested":"5 - Very interested"},"other":[]}}}]',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Form::query()
            ->whereIn('key', ['characterBio', 'userBio'])
            ->get()
            ->each(fn (Form $form) => PublishFormManager::run($form));

        $forms = Form::whereNull('prefixed_id')->get();

        $reflectedMethod = new ReflectionMethod(Form::class, 'generatePrefixedId');

        foreach ($forms as $form) {
            $form->forceFill(['prefixed_id' => $reflectedMethod->invoke($form)]);
            $form->save();
        }

        activity()->enableLogging();
    }
};
