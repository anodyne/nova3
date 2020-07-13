<?php

namespace Nova\Stories\Models;

use Illuminate\Database\Eloquent\Model;

class PostType extends Model
{
    protected $table = 'post_types';

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
