<?php

namespace Nova\Stories\Models;

use Illuminate\Database\Eloquent\Model;
use Nova\Stories\Models\Builders\PostTypeBuilder;

class PostType extends Model
{
    protected $table = 'post_types';

    protected $fillable = ['name', 'description', 'key'];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function newEloquentBuilder($query): PostTypeBuilder
    {
        return new PostTypeBuilder($query);
    }
}
