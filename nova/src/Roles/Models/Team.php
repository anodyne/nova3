<?php

declare(strict_types=1);

namespace Nova\Roles\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Laratrust\Models\Team as LaratrustTeam;
use Nova\Foundation\Concerns\LogsActivity;
use Nova\Foundation\Models\Concerns\HasTableHelpers;

/**
 * @mixin IdeHelperTeam
 */
class Team extends LaratrustTeam
{
    use HasTableHelpers;
    use HasUuids;
    use LogsActivity;

    protected $fillable = [
        'name', 'display_name', 'description',
    ];
}
