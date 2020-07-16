<?php

namespace Nova\PostTypes\Models;

use Illuminate\Database\Eloquent\Model;
use Nova\PostTypes\Models\Builders\PostTypeBuilder;

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
