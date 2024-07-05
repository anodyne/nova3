<?php

declare(strict_types=1);

namespace Nova\Setup\Actions\Database;

use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Forms\Actions\PublishFormManager;
use Nova\Forms\Enums\FormType;
use Nova\Forms\Models\Form;

class EnsureFormsAreCreated
{
    use AsAction;

    public function handle(): void
    {
        if ($this->present()) {
            return;
        }

        activity()->disableLogging();

        DB::table('forms')->insert([
            'name' => 'Character bio',
            'key' => 'characterBio',
            'type' => FormType::Advanced,
            'is_locked' => true,
            'fields' => '{"type":"doc","content":[{"type":"heading","attrs":{"class":null,"id":null,"textAlign":"start","level":2},"content":[{"type":"text","text":"Physical characteristics"}]},{"type":"paragraph","attrs":{"class":null,"textAlign":"start"},"content":[{"type":"text","text":"Exercitation ad eiusmod ullamco duis proident non veniam cillum consectetur labore est esse aute. Laborum ut dolore aliquip quis nulla nostrud occaecat cillum velit laborum officia consectetur eiusmod qui magna. Esse eiusmod consequat fugiat ut culpa esse aliqua ex irure consequat voluptate adipisicing."}]},{"type":"scribbleBlock","attrs":{"id":"224e9f5a-b303-4502-9494-e6c6cdb8d616","type":"block","identifier":"field-dropdown","values":{"label":"Gender","description":null,"name":"gender","uid":"kBhXcpeCbtdm","attributes":{"placeholder":null},"options":{"male":"Male","female":"Female","other":"Other"},"required":false,"hideWhenEmpty":false}}}]}',
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
            'fields' => '{"type":"doc","content":[{"type":"scribbleBlock","attrs":{"id":"682b1394-3c65-4dbd-bc15-468ffc257a63","type":"block","identifier":"field-dropdown","values":{"label":"Where did you hear about us?","description":null,"name":"where-did-you-hear-about-us","uid":"jbifom1bjhF5","attributes":{"placeholder":null},"options":{"Fleet page":"Fleet page","Recruitment server":"Recruitment server","Other":"Other"},"required":false,"hideWhenEmpty":true}}}]}',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Form::get()->each(fn (Form $form) => PublishFormManager::run($form));

        activity()->enableLogging();
    }

    public function present(): bool
    {
        return Form::whereIn('key', ['characterBio', 'userBio', 'applicationInfo'])->count() === 3;
    }
}
