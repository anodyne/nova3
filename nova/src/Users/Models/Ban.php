<?php

declare(strict_types=1);

namespace Nova\Users\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mchev\Banhammer\Models\Ban as BaseBan;

/**
 * @property int $id
 * @property string|null $bannable_type
 * @property int|null $bannable_id
 * @property string|null $created_by_type
 * @property int|null $created_by_id
 * @property string|null $comment
 * @property string|null $ip
 * @property \Carbon\Carbon|string|null|null $expired_at
 * @property \Carbon\CarbonImmutable|null $deleted_at
 * @property \Carbon\CarbonImmutable|null $created_at
 * @property \Carbon\CarbonImmutable|null $updated_at
 * @property array<array-key, mixed>|null $metas
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent|null $bannable
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent|null $createdBy
 * @method static Builder<static>|Ban expired()
 * @method static \Database\Factories\BanFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ban newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ban newQuery()
 * @method static Builder<static>|Ban notExpired()
 * @method static Builder<static>|Ban notPermanent()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ban onlyTrashed()
 * @method static Builder<static>|Ban permanent()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ban query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ban whereBannableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ban whereBannableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ban whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ban whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ban whereCreatedById($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ban whereCreatedByType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ban whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ban whereExpiredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ban whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ban whereIp($value)
 * @method static Builder<static>|Ban whereMeta(string $name, $value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ban whereMetas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ban whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ban withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Ban withoutTrashed()
 * @mixin \Eloquent
 */
class Ban extends BaseBan
{
    use HasFactory;
}
