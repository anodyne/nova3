<?php

namespace Nova\PostTypes\Models;

use Nova\PostTypes\Events;
use Nova\Roles\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Nova\PostTypes\Models\Casts\FieldsCast;
use Nova\PostTypes\Models\Casts\OptionsCast;
use Illuminate\Database\Eloquent\SoftDeletes;
use Nova\PostTypes\Models\Builders\PostTypeBuilder;

class PostType extends Model
{
    use SoftDeletes;

    protected $table = 'post_types';

    protected $fillable = [
        'name', 'description', 'key', 'active', 'visibility', 'fields',
        'options', 'sort', 'icon', 'color',
    ];

    protected $casts = [
        'active' => 'boolean',
        'fields' => FieldsCast::class,
        'options' => OptionsCast::class,
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
