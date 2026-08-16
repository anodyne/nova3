<?php

declare(strict_types=1);

namespace Nova\Discussions\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Nova\Discussions\Enums\MessageType;
use Nova\Foundation\Concerns\LogsActivity;
use Nova\Foundation\Models\Model;
use Nova\Users\Models\User;

/**
 * @property int $id
 * @property int $discussion_id
 * @property int|null $user_id
 * @property string $content
 * @property MessageType $type
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read \Nova\Discussions\Models\Discussion $discussion
 * @property-read bool $has_unread_messages
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Nova\Discussions\Models\DiscussionNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read User|null $user
 * @method static \Database\Factories\DiscussionMessageFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiscussionMessage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiscussionMessage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiscussionMessage query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiscussionMessage whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiscussionMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiscussionMessage whereDiscussionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiscussionMessage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiscussionMessage whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiscussionMessage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|DiscussionMessage whereUserId($value)
 * @mixin \Eloquent
 */
class DiscussionMessage extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $fillable = ['user_id', 'content', 'type'];

    protected $casts = [
        'type' => MessageType::class,
    ];

    protected $touches = ['discussion'];

    protected $with = ['user'];

    public function discussion(): BelongsTo
    {
        return $this->belongsTo(Discussion::class);
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(DiscussionNotification::class);
    }

    public function user(): BelongsTo
    {
        /** @var BelongsTo $relation */
        $relation = $this->belongsTo(User::class)->withTrashed();

        return $relation;
    }

    public function unreadCount(?User $user = null): int
    {
        return $this->notifications()
            ->where('is_seen', false)
            ->where('user_id', $user?->id ?? Auth::id())
            ->where('is_sender', false)
            ->count();
    }

    public function hasUnreadMessages(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => $this->unreadCount() > 0
        );
    }
}
