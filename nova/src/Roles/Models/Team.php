<?php

declare(strict_types=1);

namespace Nova\Roles\Models;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laratrust\Models\Team as LaratrustTeam;
use Nova\Foundation\Concerns\LogsActivity;
use Nova\Foundation\Models\Concerns\HasTableHelpers;
use Spatie\Activitylog\Models\Activity;

/**
 * @property int $id
 * @property string $name
 * @property string|null $display_name
 * @property string|null $description
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read Collection<int, Activity> $activities
 * @property-read int|null $activities_count
 *
 * @method static Builder<static>|\Nova\Roles\Models\Team newModelQuery()
 * @method static Builder<static>|\Nova\Roles\Models\Team newQuery()
 * @method static Builder<static>|\Nova\Roles\Models\Team query()
 * @method static Builder<static>|\Nova\Roles\Models\Team whereCreatedAt($value)
 * @method static Builder<static>|\Nova\Roles\Models\Team whereDescription($value)
 * @method static Builder<static>|\Nova\Roles\Models\Team whereDisplayName($value)
 * @method static Builder<static>|\Nova\Roles\Models\Team whereId($value)
 * @method static Builder<static>|\Nova\Roles\Models\Team whereName($value)
 * @method static Builder<static>|\Nova\Roles\Models\Team whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class Team extends LaratrustTeam
{
    use HasFactory;
    use HasTableHelpers;
    use LogsActivity;

    protected $fillable = [
        'name', 'display_name', 'description',
    ];
}
