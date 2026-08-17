<?php

declare(strict_types=1);

namespace Nova\Users\Models;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Mchev\Banhammer\Models\Ban as BaseBan;

/**
 * @property int $id
 * @property string|null $bannable_type
 * @property int|null $bannable_id
 * @property string|null $created_by_type
 * @property int|null $created_by_id
 * @property string|null $comment
 * @property string|null $ip
 * @property Carbon|string|null|null $expired_at
 * @property CarbonImmutable|null $deleted_at
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property array<array-key, mixed>|null $metas
 * @property-read Model|\Eloquent|null $bannable
 * @property-read Model|\Eloquent|null $createdBy
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Ban expired()
 * @method static \Database\Factories\BanFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Ban newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Ban newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Ban notExpired()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Ban notPermanent()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Ban onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Ban permanent()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Ban query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Ban whereBannableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Ban whereBannableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Ban whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Ban whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Ban whereCreatedById($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Ban whereCreatedByType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Ban whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Ban whereExpiredAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Ban whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Ban whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Ban whereMeta(string $name, $value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Ban whereMetas($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Ban whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Ban withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|\Nova\Users\Models\Ban withoutTrashed()
 *
 * @mixin \Eloquent
 */
class Ban extends BaseBan
{
    use HasFactory;
}
