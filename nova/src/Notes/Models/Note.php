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
 * @mixin IdeHelperNote
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
