<?php

declare(strict_types=1);

namespace Nova\Discussions\Models;

use Carbon\CarbonImmutable;
use Database\Factories\DiscussionFactory;
use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Auth;
use Nova\Discussions\Models\Builders\DiscussionBuilder;
use Nova\Foundation\Concerns\LogsActivity;
use Nova\Foundation\Models\Model;
use Nova\Users\Models\User;
use Spatie\Activitylog\Models\Activity;
use Spatie\PrefixedIds\Models\Concerns\HasPrefixedId;

/**
 * @property int $id
 * @property string|null $prefixed_id
 * @property string|null $discussable_type
 * @property int|null $discussable_id
 * @property string|null $subject
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read Collection<int, Activity> $activities
 * @property-read int|null $activities_count
 * @property-read DiscussionParticipant|null $pivot
 * @property-read Collection<int, User> $allParticipants
 * @property-read int|null $all_participants_count
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent|null $discussable
 * @property-read bool $has_unread_messages
 * @property-read bool $is_direct_message
 * @property-read bool $is_group_message
 * @property-read DiscussionMessage|null $lastMessage
 * @property-read Collection<int, DiscussionMessage> $messages
 * @property-read int|null $messages_count
 * @property-read Collection<int, DiscussionNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection<int, User> $participants
 * @property-read int|null $participants_count
 * @property-read string $participants_string
 * @property-read string $truncated_participants_string
 *
 * @method static DiscussionBuilder<static>|Discussion conversation()
 * @method static DiscussionBuilder<static>|Discussion directMessage()
 * @method static DiscussionFactory factory($count = null, $state = [])
 * @method static DiscussionBuilder<static>|Discussion forCurrentUser()
 * @method static DiscussionBuilder<static>|Discussion groupMessage()
 * @method static DiscussionBuilder<static>|Discussion newModelQuery()
 * @method static DiscussionBuilder<static>|Discussion newQuery()
 * @method static DiscussionBuilder<static>|Discussion query()
 * @method static DiscussionBuilder<static>|Discussion searchFor(string $search)
 * @method static DiscussionBuilder<static>|Discussion whereCreatedAt($value)
 * @method static DiscussionBuilder<static>|Discussion whereDiscussableId($value)
 * @method static DiscussionBuilder<static>|Discussion whereDiscussableType($value)
 * @method static DiscussionBuilder<static>|Discussion whereId($value)
 * @method static DiscussionBuilder<static>|Discussion wherePrefixedId($value)
 * @method static DiscussionBuilder<static>|Discussion whereSubject($value)
 * @method static DiscussionBuilder<static>|Discussion whereUpdatedAt($value)
 * @method static DiscussionBuilder<static>|Discussion withoutCurrentUser()
 *
 * @mixin \Eloquent
 */
#[UseEloquentBuilder(DiscussionBuilder::class)]
class Discussion extends Model
{
    use HasFactory;
    use HasPrefixedId;
    use LogsActivity;

    protected $fillable = [
        'subject',
    ];

    public function allParticipants(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'discussion_participant')
            ->withTrashed()
            ->using(DiscussionParticipant::class);
    }

    public function discussable(): MorphTo
    {
        return $this->morphTo();
    }

    public function hasUnreadMessages(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => $this->unreadCount() > 0
        );
    }

    public function isDirectMessage(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => $this->allParticipants()->count() === 2
        );
    }

    public function isGroupMessage(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => $this->allParticipants()->count() > 2
        );
    }

    public function lastMessage(): HasOne
    {
        return $this->hasOne(DiscussionMessage::class)->latestOfMany();
    }

    public function messages(): HasMany
    {
        return $this->hasMany(DiscussionMessage::class);
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(DiscussionNotification::class);
    }

    public function participants(): BelongsToMany
    {
        return $this->allParticipants()
            ->where('users.id', '!=', Auth::id());
    }

    public function participantsString(): Attribute
    {
        return Attribute::make(
            get: fn (): string => $this->participants->implode('name', ', ')
        );
    }

    public function truncatedParticipantsString(): Attribute
    {
        return Attribute::make(
            get: function (): string {
                $participants = $this->participants;
                $count = $participants->count();
                $remaining = $count - 2;

                if ($remaining > 0) {
                    return implode(', ', [
                        ...$participants->take(2)->pluck('name'),
                        ...["+{$remaining} more"],
                    ]);
                }

                return implode(', ', $participants->pluck('name')->toArray());
            }
        );
    }

    public function unreadCount(?User $user = null): int
    {
        return $this->notifications()
            ->where('is_seen', false)
            ->where('user_id', $user->id ?? Auth::id())
            ->where('is_sender', false)
            ->count();
    }
}
