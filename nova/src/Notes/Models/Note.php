<?php

declare(strict_types=1);

namespace Nova\Notes\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Collection;
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
use Spatie\Activitylog\Models\Activity;
use Spatie\PrefixedIds\Models\Concerns\HasPrefixedId;

/**
 * @property int $id
 * @property string|null $prefixed_id
 * @property int $user_id
 * @property string $title
 * @property string|null $content
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read Collection<int, Activity> $activities
 * @property-read int|null $activities_count
 * @property-read User|null $author
 *
 * @method static \Nova\Notes\Models\Builders\NoteBuilder<static>|\Nova\Notes\Models\Note author(\Nova\Users\Models\User $user)
 * @method static \Nova\Notes\Models\Builders\NoteBuilder<static>|\Nova\Notes\Models\Note currentUser()
 * @method static \Database\Factories\NoteFactory factory($count = null, $state = [])
 * @method static \Nova\Notes\Models\Builders\NoteBuilder<static>|\Nova\Notes\Models\Note newModelQuery()
 * @method static \Nova\Notes\Models\Builders\NoteBuilder<static>|\Nova\Notes\Models\Note newQuery()
 * @method static \Nova\Notes\Models\Builders\NoteBuilder<static>|\Nova\Notes\Models\Note query()
 * @method static \Nova\Notes\Models\Builders\NoteBuilder<static>|\Nova\Notes\Models\Note searchFor($search)
 * @method static \Nova\Notes\Models\Builders\NoteBuilder<static>|\Nova\Notes\Models\Note whereContent($value)
 * @method static \Nova\Notes\Models\Builders\NoteBuilder<static>|\Nova\Notes\Models\Note whereCreatedAt($value)
 * @method static \Nova\Notes\Models\Builders\NoteBuilder<static>|\Nova\Notes\Models\Note whereId($value)
 * @method static \Nova\Notes\Models\Builders\NoteBuilder<static>|\Nova\Notes\Models\Note wherePrefixedId($value)
 * @method static \Nova\Notes\Models\Builders\NoteBuilder<static>|\Nova\Notes\Models\Note whereTitle($value)
 * @method static \Nova\Notes\Models\Builders\NoteBuilder<static>|\Nova\Notes\Models\Note whereUpdatedAt($value)
 * @method static \Nova\Notes\Models\Builders\NoteBuilder<static>|\Nova\Notes\Models\Note whereUserId($value)
 *
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

    protected $dispatchesEvents = [
        'created' => NoteCreated::class,
        'deleted' => NoteDeleted::class,
        'updated' => NoteUpdated::class,
    ];

    protected $fillable = ['user_id', 'title', 'content'];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return $this->baseActivitylogOptions()->logExcept(['content']);
    }
}
