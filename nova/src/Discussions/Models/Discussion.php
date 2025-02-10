<?php

declare(strict_types=1);

namespace Nova\Discussions\Models;

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

class Discussion extends Model
{
    use HasFactory;
    use HasPrefixedId;
    use LogsActivity;

    protected $fillable = [
        'subject',
    ];

    public function discussable(): MorphTo
    {
        return $this->morphTo();
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

    public function allParticipants(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'discussion_participant')
            ->using(DiscussionParticipant::class)
            ->withTrashed();
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

                return $participants->implode('name', ', ');
            }
        );
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

    public function newEloquentBuilder($query): DiscussionBuilder
    {
        return new DiscussionBuilder($query);
    }
}
