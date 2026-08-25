<?php

declare(strict_types=1);

namespace Nova\Discussions\Models;

use Database\Factories\DiscussionMessageFactory;
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
 * @mixin IdeHelperDiscussionMessage
 */
class DiscussionMessage extends Model
{
    /** @use HasFactory<DiscussionMessageFactory> */
    use HasFactory;

    use LogsActivity;

    protected $casts = [
        'type' => MessageType::class,
    ];

    protected $fillable = ['user_id', 'content', 'type'];

    /** @var array<string> */
    protected $touches = ['discussion'];

    protected $with = ['user'];

    /**
     * @return BelongsTo<Discussion, $this>
     */
    public function discussion(): BelongsTo
    {
        return $this->belongsTo(Discussion::class);
    }

    /**
     * @return HasMany<DiscussionNotification, $this>
     */
    public function notifications(): HasMany
    {
        return $this->hasMany(DiscussionNotification::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        /** @var BelongsTo<User, $this> $relation */
        $relation = $this->belongsTo(User::class)->withTrashed();

        return $relation;
    }

    /**
     * @return Attribute<bool, never>
     */
    public function hasUnreadMessages(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => $this->unreadCount() > 0
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
