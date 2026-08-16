<?php

declare(strict_types=1);

namespace Nova\Notes\Models;

use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Nova\Foundation\Concerns\LogsActivity;
use Nova\Foundation\Models\Model;
use Nova\Notes\Events\NoteCreated;
use Nova\Notes\Events\NoteDeleted;
use Nova\Notes\Events\NoteUpdated;
use Nova\Notes\Models\Builders\NoteBuilder;
use Nova\Users\Models\User;
use Spatie\Activitylog\LogOptions;
use Spatie\PrefixedIds\Models\Concerns\HasPrefixedId;

/**
 * @property int $id
 * @property string|null $prefixed_id
 * @property int $user_id
 * @property string $title
 * @property string|null $content
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Activitylog\Models\Activity> $activities
 * @property-read int|null $activities_count
 * @property-read User|null $author
 * @method static NoteBuilder<static>|Note author(\Nova\Users\Models\User $user)
 * @method static NoteBuilder<static>|Note currentUser()
 * @method static \Database\Factories\NoteFactory factory($count = null, $state = [])
 * @method static NoteBuilder<static>|Note newModelQuery()
 * @method static NoteBuilder<static>|Note newQuery()
 * @method static NoteBuilder<static>|Note query()
 * @method static NoteBuilder<static>|Note searchFor($search)
 * @method static NoteBuilder<static>|Note whereContent($value)
 * @method static NoteBuilder<static>|Note whereCreatedAt($value)
 * @method static NoteBuilder<static>|Note whereId($value)
 * @method static NoteBuilder<static>|Note wherePrefixedId($value)
 * @method static NoteBuilder<static>|Note whereTitle($value)
 * @method static NoteBuilder<static>|Note whereUpdatedAt($value)
 * @method static NoteBuilder<static>|Note whereUserId($value)
 * @mixin \Eloquent
 */
#[UseEloquentBuilder(NoteBuilder::class)]
class Note extends Model
{
    use HasFactory;
    use HasPrefixedId;
    use LogsActivity {
        LogsActivity::getActivitylogOptions as baseActivitylogOptions;
    }

    protected $fillable = ['user_id', 'title', 'content'];

    protected $dispatchesEvents = [
        'created' => NoteCreated::class,
        'deleted' => NoteDeleted::class,
        'updated' => NoteUpdated::class,
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return $this->baseActivitylogOptions()->logExcept(['content']);
    }
}
