<?php

declare(strict_types=1);

namespace Nova\PostTypes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nova\PostTypes\Data\Fields;
use Nova\PostTypes\Data\Options;
use Nova\PostTypes\Events;
use Nova\PostTypes\Models\Builders\PostTypeBuilder;
use Nova\PostTypes\Models\States\PostTypeStatus;
use Nova\Roles\Models\Role;
use Spatie\ModelStates\HasStates;

class PostType extends Model
{
    use HasFactory;
    use HasStates;
    use SoftDeletes;

    protected $table = 'post_types';

    protected $fillable = [
        'name', 'description', 'key', 'status', 'visibility', 'fields',
        'options', 'sort', 'icon', 'color',
    ];

    protected $casts = [
        'fields' => Fields::class,
        'options' => Options::class,
        'sort' => 'int',
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

    public function newEloquentBuilder($query): PostTypeBuilder
    {
        return new PostTypeBuilder($query);
    }
}
