<?php

declare(strict_types=1);

namespace Nova\Conversations\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Nova\Users\Models\User;

class Conversation extends Model
{
    use HasFactory;

    public function messages(): HasMany
    {
        return $this->hasMany(ConversationMessage::class);
    }

    public function recipients(): BelongsToMany
    {
        return $this->users()->wherePivot('user_id', '!=', Auth::id());
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
