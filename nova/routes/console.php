<?php

declare(strict_types=1);

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Nova\Announcements\Models\Announcement;
use Nova\Applications\Models\Application;
use Nova\Characters\Models\Character;
use Nova\Characters\Models\CharacterPosition;
use Nova\Characters\Models\CharacterUser;
use Nova\Departments\Models\Department;
use Nova\Departments\Models\Position;
use Nova\Discussions\Models\Discussion;
use Nova\Discussions\Models\DiscussionMessage;
use Nova\Discussions\Models\DiscussionNotification;
use Nova\Discussions\Models\DiscussionParticipant;
use Nova\Forms\Models\Form;
use Nova\Foundation\Models\ExternalChangelog;
use Nova\Foundation\Models\ExternalContent;
use Nova\Foundation\Models\StatusHistory;
use Nova\Setup\Models\Upgrade;
use Nova\Stories\Models\Post;
use Nova\Stories\Models\PostAuthor;
use Nova\Stories\Models\Story;
use Nova\Users\Models\User;
use Nova\Users\Models\UserNotificationPreference;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('nova:refresh', function () {
    $this->call('db:wipe');
    $this->call('migrate:fresh');
    $this->call('operations:process');
    $this->call('db:seed');

    $this->call('nova:sync-external-content');

    // $this->call('scout:delete-all-indexes');
    // $this->call('scout:import', ['model' => 'App\Models\Product']);
    // $this->call('scout:sync-index-settings');

    $this->call('optimize:clear');
    $this->call('storage:link');
});

Artisan::command('nova:reset-migration', function () {
    Schema::disableForeignKeyConstraints();

    collect([
        User::class,
        UserNotificationPreference::class,
        Character::class,
        CharacterPosition::class,
        CharacterUser::class,
        Department::class,
        Position::class,
        StatusHistory::class,
        Story::class,
        Post::class,
        PostAuthor::class,
        Announcement::class,
        Upgrade::class,
        Application::class,
        Discussion::class,
        DiscussionMessage::class,
        DiscussionParticipant::class,
        DiscussionNotification::class,
    ])->each(fn ($model) => $model::truncate());

    $characterForm = Form::with(['submissions.responses', 'formFields'])->key('characterBio')->first();

    $characterForm->submissions->each(fn ($submission) => $submission->load('responses')->responses->each->delete());
    $characterForm->submissions->each->delete();
    $characterForm->formFields->each->delete();

    $userForm = Form::with(['submissions.responses', 'formFields'])->key('userBio')->first();

    $userForm->submissions->each(fn ($submission) => $submission->load('responses')->responses->each->delete());
    $userForm->submissions->each->delete();
    $userForm->formFields->each->delete();

    Schema::enableForeignKeyConstraints();

    Cache::forget('migration_complete');

    $this->info('Migration reset complete');
});

Artisan::command('nova:get-timezones {token}', function (string $token) {
    $response = Http::withToken($token)
        ->get('https://api.savvycal.com/v1/time_zones');

    $collection = collect($response->json())
        ->filter(fn ($tz) => $tz['golden'])
        ->map(fn ($tz) => [
            'id' => data_get($tz, 'id'),
            'name' => sprintf(
                '(GMT%s) %s',
                data_get($tz, 'formatted_offset'),
                data_get($tz, 'long_name')
            ),
        ]);

    File::put(nova_path('timezones.json'), json_encode($collection));

    $this->info('Timezones updated');
});

Artisan::command('nova:sync-external-content', function () {
    ExternalChangelog::syncFromAnodyne();
    ExternalContent::syncFromAnodyne();

    $this->info('External content and changelog has been synced.');
});
