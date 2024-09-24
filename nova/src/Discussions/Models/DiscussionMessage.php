<?php

declare(strict_types=1);

namespace Nova\Discussions\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Nova\Discussions\Enums\MessageType;
use Nova\Users\Models\User;

class DiscussionMessage extends Model
{
    use HasFactory;

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
        return $this->belongsTo(User::class);
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
