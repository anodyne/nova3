<?php

declare(strict_types=1);

namespace Nova\Setup\Actions\Migration;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Setup\Livewire\Concerns\HandlesDates;
use Nova\Setup\Livewire\Concerns\HandlesNewIds;
use Nova\Setup\Models\Upgrade;

/**
 * @phpstan-type LegacyPrivateMessage object{
 *     privmsgs_author_user: int|null,
 *     privmsgs_subject: string,
 *     privmsgs_date: int|null,
 *     privmsgs_content: string,
 *     privmsgs_author_display: string,
 *     privmsgs_id: int
 * }
 */
class MigratePrivateMessage
{
    use AsAction;
    use HandlesDates;
    use HandlesNewIds;

    /**
     * @param  LegacyPrivateMessage  $model
     * @param  Collection<int, Upgrade>|null  $users
     */
    public function handle(object $model, ?Collection $users): void
    {
        $newAuthorId = $this->getNewId(
            id: $model->privmsgs_author_user,
            collection: $users,
            upgradeKey: 'user'
        );

        DB::transaction(function () use ($model, $newAuthorId, $users): void {
            $discussionId = DB::table('discussions')->insertGetId([
                'subject' => $model->privmsgs_subject,
                'created_at' => $created = $this->convertDate($model->privmsgs_date, now('UTC')),
                'updated_at' => $created,
            ]);

            $messageId = DB::table('discussion_messages')->insertGetId([
                'discussion_id' => $discussionId,
                'user_id' => $newAuthorId,
                'content' => $model->privmsgs_content,
                'updated_at' => $created,
            ]);

            if ($model->privmsgs_author_display === 'y') {
                DB::table('discussion_participant')->insert([
                    'discussion_id' => $discussionId,
                    'user_id' => $newAuthorId,
                    'created_at' => $created,
                    'updated_at' => $created,
                ]);

                DB::table('discussion_notifications')->insert([
                    'discussion_id' => $discussionId,
                    'discussion_message_id' => $messageId,
                    'user_id' => $newAuthorId,
                    'is_seen' => true,
                    'is_sender' => true,
                    'created_at' => $created,
                    'updated_at' => $created,
                ]);
            }

            $migratedIds = Upgrade::type('private-message-recipient')->pluck('old_id');

            $prefix = DB::connection('nova2')->getTablePrefix();

            DB::connection('nova2')
                ->table('privmsgs_to')
                ->join('users', 'privmsgs_to.pmto_recipient_user', '=', 'users.userid')
                ->where('pmto_message', $model->privmsgs_id)
                ->where('pmto_display', 'y')
                ->whereNotIn('pmto_id', $migratedIds)
                ->groupBy('privmsgs_to.pmto_recipient_user')
                ->selectRaw("{$prefix}privmsgs_to.pmto_recipient_user, ANY_VALUE({$prefix}privmsgs_to.pmto_id) as pmto_id, ANY_VALUE({$prefix}privmsgs_to.pmto_unread) as pmto_unread")
                ->get()
                ->each(function ($recipient) use ($discussionId, $users, $created, $model, $messageId): void {
                    $newUserId = $this->getNewId(
                        id: $recipient->pmto_recipient_user,
                        collection: $users,
                        upgradeKey: 'user'
                    );

                    if ($model->privmsgs_author_user != $recipient->pmto_recipient_user) {
                        $recipientId = DB::table('discussion_participant')->insertGetId([
                            'discussion_id' => $discussionId,
                            'user_id' => $newUserId,
                            'created_at' => $created,
                            'updated_at' => $created,
                        ]);

                        DB::table('discussion_notifications')->insert([
                            'discussion_id' => $discussionId,
                            'discussion_message_id' => $messageId,
                            'user_id' => $newUserId,
                            'is_seen' => $recipient->pmto_unread === 'y',
                            'is_sender' => false,
                            'created_at' => $created,
                            'updated_at' => $created,
                        ]);

                        Upgrade::firstOrCreate([
                            'type' => 'private-message-recipient',
                            'old_id' => $recipient->pmto_id,
                            'new_id' => $recipientId,
                        ]);
                    }
                });

            Upgrade::firstOrCreate([
                'type' => 'private-message',
                'old_id' => $model->privmsgs_id,
                'new_id' => $discussionId,
            ]);
        });
    }

    /** @param LegacyPrivateMessage $model */
    public function asJob(object $model): void
    {
        $this->handle(model: $model, users: null);
    }
}
