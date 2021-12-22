<?php

declare(strict_types=1);

namespace Nova\Forms\Models;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    protected $fillable = ['name', 'key', 'description'];

    public function blocks()
    {
        return $this->belongsToMany(Block::class, 'form_block')
            ->using(FormBlock::class)
            ->withPivot('id', 'sort', 'parent_id', 'settings')
            ->orderBy('pivot_sort');
    }
}
