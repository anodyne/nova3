<?php

declare(strict_types=1);

namespace Nova\Discussions\Models;

use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Nova\Discussions\Models\Builders\DiscussionParticipantBuilder;
use Nova\Foundation\Models\Concerns\HasTableHelpers;
use Nova\Users\Models\User;

#[UseEloquentBuilder(DiscussionParticipantBuilder::class)]
class DiscussionParticipant extends Pivot
{
    use HasTableHelpers;

    protected $fillable = [
        'discussion_id',
        'deleted_at',
    ];

    public function discussion(): BelongsTo
    {
        return $this->belongsTo(Discussion::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
