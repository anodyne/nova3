<?php

declare(strict_types=1);

namespace Nova\Users\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Nova\Foundation\Models\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $ip_address
 * @property \Carbon\CarbonImmutable $created_at
 * @property-read \Nova\Users\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Login newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Login newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Login query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Login whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Login whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Login whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Login whereUserId($value)
 * @mixin \Eloquent
 */
class Login extends Model
{
    public $timestamps = false;

    protected $fillable = ['ip_address', 'created_at'];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
