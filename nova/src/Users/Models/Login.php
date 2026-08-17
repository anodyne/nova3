<?php

declare(strict_types=1);

namespace Nova\Users\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Nova\Foundation\Models\Model;

/**
 * @property int $id
 * @property int $user_id
 * @property string $ip_address
 * @property CarbonImmutable $created_at
 * @property-read User|null $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Login newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Login newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Login query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Login whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Login whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Login whereIpAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Login whereUserId($value)
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
