<?php

declare(strict_types=1);

namespace Nova\Discussions\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Nova\Discussions\Enums\MessageType;
use Nova\Foundation\Concerns\LogsActivity;
use Nova\Foundation\Models\Model;
use Nova\Users\Models\User;
use Spatie\Activitylog\Models\Activity;

/**
 * @property int $id
 * @property int $discussion_id
 * @property int|null $user_id
 * @property string $content
 * @property MessageType $type
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read Collection<int, Activity> $activities
 * @property-read int|null $activities_count
 * @property-read Discussion $discussion
 * @property-read bool $has_unread_messages
 * @property-read Collection<int, DiscussionNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read User|null $user
 *
 * @method static \Database\Factories\DiscussionMessageFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Discussions\Models\DiscussionMessage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Discussions\Models\DiscussionMessage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Discussions\Models\DiscussionMessage query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Discussions\Models\DiscussionMessage whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Discussions\Models\DiscussionMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Discussions\Models\DiscussionMessage whereDiscussionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Discussions\Models\DiscussionMessage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Discussions\Models\DiscussionMessage whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Discussions\Models\DiscussionMessage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Discussions\Models\DiscussionMessage whereUserId($value)
 *
 * @mixin \Eloquent
 */
class DiscussionMessage extends Model
{
    use HasFactory;
    use LogsActivity;

    protected $casts = [
        'type' => MessageType::class,
    ];

    protected $fillable = ['user_id', 'content', 'type'];

    protected $touches = ['discussion'];

    protected $with = ['user'];

    public function discussion(): BelongsTo
    {
        return $this->belongsTo(Discussion::class);
    }

    public function hasUnreadMessages(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => $this->unreadCount() > 0
        );
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(DiscussionNotification::class);
    }

    public function unreadCount(?User $user = null): int
    {
        return $this->notifications()
            ->where('is_seen', false)
            ->where('user_id', $user?->id ?? Auth::id())
            ->where('is_sender', false)
            ->count();
    }

    public function user(): BelongsTo
    {
        /** @var BelongsTo $relation */
        $relation = $this->belongsTo(User::class)->withTrashed();

        return $relation;
    }
}
