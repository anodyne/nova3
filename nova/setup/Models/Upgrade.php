<?php

declare(strict_types=1);

namespace Nova\Setup\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Upgrade extends Model
{
    use HasUuids;

    protected $table = 'upgrade';

    protected $fillable = ['type', 'new_id', 'old_id'];

    protected $casts = [
        'new_id' => 'string',
        'old_id' => 'integer',
    ];

    /**
     * @param  Builder<self>  $query
     * @return Builder<self>
     */
    public function scopeType(Builder $query, string $type): Builder
    {
        return $query->where('type', $type);
    }
}
