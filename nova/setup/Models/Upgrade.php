<?php

declare(strict_types=1);

namespace Nova\Setup\Models;

use Illuminate\Database\Eloquent\Model;

class Upgrade extends Model
{
    protected $table = 'upgrade';

    protected $fillable = ['type', 'new_id', 'old_id'];

    protected $casts = [
        'new_id' => 'integer',
        'old_id' => 'integer',
    ];

    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }
}
