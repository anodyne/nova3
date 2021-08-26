<?php

declare(strict_types=1);

namespace Nova\PostTypes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nova\PostTypes\Events;
use Nova\PostTypes\Models\Builders\PostTypeBuilder;
use Nova\PostTypes\Values\Fields;
use Nova\PostTypes\Values\Options;
use Nova\Roles\Models\Role;

class PostType extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'post_types';

    protected $fillable = [
        'name', 'description', 'key', 'active', 'visibility', 'fields',
        'options', 'sort', 'icon', 'color',
    ];

    protected $casts = [
        'active' => 'boolean',
        'fields' => Fields::class,
        'options' => Options::class,
        'sort' => 'int',
    ];

    protected $dispatchesEvents = [
        'created' => Events\PostTypeCreated::class,
        'deleted' => Events\PostTypeDeleted::class,
        'updated' => Events\PostTypeUpdated::class,
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function newEloquentBuilder($query): PostTypeBuilder
    {
        return new PostTypeBuilder($query);
    }
}
