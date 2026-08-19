<?php

declare(strict_types=1);

namespace Nova\Users\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Nova\Foundation\Models\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $ip_address
 * @property CarbonImmutable $created_at
 * @property-read User|null $user
 *
 * @method static Builder<static>|Login newModelQuery()
 * @method static Builder<static>|Login newQuery()
 * @method static Builder<static>|Login query()
 * @method static Builder<static>|Login whereCreatedAt($value)
 * @method static Builder<static>|Login whereId($value)
 * @method static Builder<static>|Login whereIpAddress($value)
 * @method static Builder<static>|Login whereUserId($value)
 *
 * @mixin \Eloquent
 */
class Login extends Model
{
    public $timestamps = false;

    protected $casts = [
        'created_at' => 'datetime',
    ];

    protected $fillable = ['ip_address', 'created_at'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
