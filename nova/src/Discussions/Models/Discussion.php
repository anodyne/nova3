<?php

declare(strict_types=1);

namespace Nova\Discussions\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Auth;
use Nova\Discussions\Models\Builders\DiscussionBuilder;
use Nova\Users\Models\User;
use Spatie\PrefixedIds\Models\Concerns\HasPrefixedId;

class Discussion extends Model
{
    use HasFactory;
    use HasPrefixedId;

    protected $fillable = [
        'name',
        'is_direct_message',
        'direct_message_participants',
    ];

    protected $casts = [
        'is_direct_message' => 'bool',
        'direct_message_participants' => 'array',
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

    public function newEloquentBuilder($query): DiscussionBuilder
    {
        return new DiscussionBuilder($query);
    }
}
