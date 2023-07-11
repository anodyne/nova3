<?php

declare(strict_types=1);

namespace Nova\Pages\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Nova\Navigation\Models\Navigation;
use Nova\Pages\Enums\PageVerb;
use Nova\Pages\Models\Builders\PageBuilder;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Page extends Model
{
    use LogsActivity;

    protected $fillable = [
        'uri', 'key', 'verb', 'resource', 'layout',
    ];

    protected $casts = [
        'verb' => PageVerb::class,
    ];

    public function navigation(): HasOne
    {
        return $this->hasOne(Navigation::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->useLogName('admin')
            ->setDescriptionForEvent(
                fn (string $eventName) => ":subject.key page was {$eventName}"
            );
    }

    public function newEloquentBuilder($query): PageBuilder
    {
        return new PageBuilder($query);
    }
}
