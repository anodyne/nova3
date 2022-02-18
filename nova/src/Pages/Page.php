<?php

declare(strict_types=1);

namespace Nova\Pages;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Page extends Model
{
    use LogsActivity;

    protected $fillable = [
        'uri', 'key', 'verb', 'resource', 'layout',
    ];

    /**
     * Scope the query to the page key.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $key
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeKey($query, $key)
    {
        return $query->where('key', $key);
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
}
