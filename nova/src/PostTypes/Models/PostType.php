<?php

declare(strict_types=1);

namespace Nova\PostTypes\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nova\Posts\Models\Post;
use Nova\PostTypes\Data\Fields;
use Nova\PostTypes\Data\Options;
use Nova\PostTypes\Enums\PostTypeStatus;
use Nova\PostTypes\Events;
use Nova\PostTypes\Models\Builders\PostTypeBuilder;
use Nova\Roles\Models\Role;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\ModelStates\HasStates;

class PostType extends Model implements Sortable
{
    use HasFactory;
    use HasStates;
    use SortableTrait;

    protected $table = 'post_types';

    protected $fillable = [
        'name', 'description', 'key', 'status', 'visibility', 'fields',
        'options', 'order_column', 'icon', 'color', 'role_id',
    ];

    protected $casts = [
        'fields' => Fields::class,
        'options' => Options::class,
        'order_column' => 'integer',
        'status' => PostTypeStatus::class,
    ];

    protected $dispatchesEvents = [
        'created' => Events\PostTypeCreated::class,
        'deleted' => Events\PostTypeDeleted::class,
        'updated' => Events\PostTypeUpdated::class,
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function includedInPostTracking(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => $this->options->includedInPostTracking
        );
    }

    public function notifiesUsers(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => $this->options->notifiesUsers
        );
    }

    public function newEloquentBuilder($query): PostTypeBuilder
    {
        return new PostTypeBuilder($query);
    }
}
