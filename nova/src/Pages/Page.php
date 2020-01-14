<?php

namespace Nova\Pages;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Page extends Model
{
    use LogsActivity;

    protected static $logFillable = true;

    protected static $logName = 'admin';

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

    /**
     * Set the description for logging.
     *
     * @param  string  $eventName
     *
     * @return string
     */
    public function getDescriptionForEvent(string $eventName): string
    {
        return ":subject.key page was {$eventName}";
    }
}
