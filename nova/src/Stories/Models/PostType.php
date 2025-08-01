<?php

declare(strict_types=1);

namespace Nova\Stories\Models;

use Nova\Stories\Events\PostTypeCreated;
use Nova\Stories\Events\PostTypeDeleted;
use Nova\Stories\Events\PostTypeUpdated;
use Nova\Stories\Events\PostTypeForceDeleted;
use Nova\Stories\Events\PostTypeRestored;
use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nova\Foundation\Concerns\LogsActivity;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Foundation\Models\Model;
use Nova\Roles\Models\Role;
use Nova\Stories\Data\Fields;
use Nova\Stories\Data\Options;
use Nova\Stories\Enums\PostTypeVisibility;
use Nova\Stories\Events;
use Nova\Stories\Models\Builders\PostTypeBuilder;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\ModelStates\HasStates;
use Spatie\PrefixedIds\Models\Concerns\HasPrefixedId;

#[UseEloquentBuilder(PostTypeBuilder::class)]
class PostType extends Model implements Sortable
{
    use HasFactory;
    use HasPrefixedId;
    use HasStates;
    use LogsActivity;
    use SoftDeletes;
    use SortableTrait;

    protected $table = 'post_types';

    protected $fillable = [
        'color',
        'description',
        'fields',
        'icon',
        'key',
        'name',
        'options',
        'order_column',
        'role_id',
        'status',
        'visibility',
    ];

    protected $casts = [
        'fields' => Fields::class,
        'options' => Options::class,
        'order_column' => 'integer',
        'status' => BasicStatus::class,
        'visibility' => PostTypeVisibility::class,
    ];

    protected $dispatchesEvents = [
        'created' => PostTypeCreated::class,
        'deleted' => PostTypeDeleted::class,
        'updated' => PostTypeUpdated::class,
        'forceDeleted' => PostTypeForceDeleted::class,
        'restored' => PostTypeRestored::class,
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function publishedPosts(): HasMany
    {
        return $this->posts()->published();
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * This attribute exists to allow for the table to have a column for this data.
     */
    public function includedInPostTracking(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => $this->options->includedInPostTracking
        );
    }

    /**
     * This attribute exists to allow for the table to have a column for this data.
     */
    public function notifiesUsers(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => $this->options->notifiesUsers
        );
    }
}
