<?php

declare(strict_types=1);

namespace Nova\Discussions\Models;

use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Nova\Discussions\Models\Builders\DiscussionParticipantBuilder;
use Nova\Foundation\Models\Concerns\HasTableHelpers;
use Nova\Users\Models\User;

/**
 * @mixin IdeHelperDiscussionParticipant
 */
#[UseEloquentBuilder(DiscussionParticipantBuilder::class)]
class DiscussionParticipant extends Pivot
{
    use HasTableHelpers;
    use HasUuids;

    protected $fillable = [
        'discussion_id',
        'deleted_at',
    ];

    /**
     * @return BelongsTo<Discussion, $this>
     */
    public function discussion(): BelongsTo
    {
        return $this->belongsTo(Discussion::class);
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
}
