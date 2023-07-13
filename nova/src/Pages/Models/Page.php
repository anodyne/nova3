<?php

declare(strict_types=1);

namespace Nova\Pages\Models;

use Illuminate\Database\Eloquent\Model;
use Nova\Pages\Enums\PageVerb;
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

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->useLogName('admin')
            ->setDescriptionForEvent(
                fn (string $eventName) => ":subject.key page was {$eventName}"
            );
    }

    public function newEloquentBuilder($query): Builders\PageBuilder
    {
        return new Builders\PageBuilder($query);
    }
}
