<?php

declare(strict_types=1);

namespace Nova\Discussions\Models;

use Database\Factories\DiscussionFactory;
use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Casts\Attribute;
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
use Spatie\PrefixedIds\Models\Concerns\HasPrefixedId;

/**
 * @mixin IdeHelperDiscussion
 */
#[UseEloquentBuilder(DiscussionBuilder::class)]
class Discussion extends Model
{
    /** @use HasFactory<DiscussionFactory> */
    use HasFactory;

    use HasPrefixedId;
    use LogsActivity;

    protected $fillable = [
        'subject',
    ];

    /**
     * @return BelongsToMany<User, $this, DiscussionParticipant, 'pivot'>
     */
    public function allParticipants(): BelongsToMany
    {
        /** @var BelongsToMany<User, $this, DiscussionParticipant, 'pivot'> $relation */
        $relation = $this->belongsToMany(User::class, 'discussion_participant')
            ->using(DiscussionParticipant::class)
            ->withTrashed();

        return $relation;
    }

    /**
     * @return MorphTo<\Illuminate\Database\Eloquent\Model, $this>
     */
    public function discussable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * @return HasOne<DiscussionMessage, $this>
     */
    public function lastMessage(): HasOne
    {
        return $this->hasOne(DiscussionMessage::class)->latestOfMany();
    }

    /**
     * @return HasMany<DiscussionMessage, $this>
     */
    public function messages(): HasMany
    {
        return $this->hasMany(DiscussionMessage::class);
    }

    /**
     * @return HasMany<DiscussionNotification, $this>
     */
    public function notifications(): HasMany
    {
        return $this->hasMany(DiscussionNotification::class);
    }

    /**
     * @return BelongsToMany<User, $this, DiscussionParticipant, 'pivot'>
     */
    public function participants(): BelongsToMany
    {
        return $this->allParticipants()
            ->where('users.id', '!=', Auth::id());
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

    /**
     * @return Attribute<bool, never>
     */
    public function isDirectMessage(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => $this->allParticipants()->count() === 2
        );
    }

    /**
     * @return Attribute<bool, never>
     */
    public function isGroupMessage(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => $this->allParticipants()->count() > 2
        );
    }

    /**
     * @return Attribute<string, never>
     */
    public function participantsString(): Attribute
    {
        return Attribute::make(
            get: fn (): string => $this->participants->implode('name', ', ')
        );
    }

    /**
     * @return Attribute<string, never>
     */
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
