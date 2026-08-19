<?php

declare(strict_types=1);

namespace Nova\Setup\Actions\Migration;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Nova\Forms\Actions\CreateFormSubmission;
use Nova\Forms\Models\Form;
use Nova\Setup\Models\Upgrade;
use Nova\Users\Actions\PopulateAccountPreferences;
use Nova\Users\Actions\PopulateNotificationPreferences;
use Nova\Users\Data\PronounsData;
use Nova\Users\Data\UserModerations;
use Nova\Users\Models\User;

class MigrateUser extends Migration
{
    public function handle(object $model): void
    {
        $form = Form::key('userBio')->first();

        DB::transaction(function () use ($model, $form): void {
            $userId = DB::table('users')
                ->insertGetId([
                    'name' => $model->name,
                    'email' => $model->email,
                    'password' => bcrypt(Str::random()),
                    'force_password_reset' => true,
                    'status' => $model->status,
                    'pronouns' => PronounsData::from('none')->toJson(),
                    'moderations' => UserModerations::from(
                        announcements: $model->moderate_news === 'y',
                        posts: $model->moderate_logs === 'y' || $model->moderate_posts === 'y'
                    )->toJson(),
                    'created_at' => $joinDate = $this->convertDate($model->join_date),
                    'updated_at' => $this->convertDate($model->last_update, $joinDate),
                ]);

            DB::table('status_history')->insert([
                'statusable_type' => 'user',
                'statusable_id' => $userId,
                'status' => 'active',
                'started_at' => $joinDate,
                'ended_at' => $this->convertDate($model->leave_date),
            ]);

            PopulateAccountPreferences::run($user = User::find($userId));
            PopulateNotificationPreferences::run($user);

            if ($form) {
                CreateFormSubmission::run($form, $user);
            }

            Upgrade::firstOrCreate([
                'type' => 'user',
                'old_id' => $model->userid,
                'new_id' => $user->id,
            ]);
        });
    }

    public function asJob(object $model): void
    {
        $this->handle($model);
    }
}
