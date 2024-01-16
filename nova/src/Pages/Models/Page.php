<?php

declare(strict_types=1);

namespace Nova\Pages\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Nova\Pages\Enums\PageVerb;
use Nova\Pages\Models\Collections\PagesCollection;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Page extends Model
{
    use LogsActivity;

    protected $fillable = [
        'uri', 'key', 'verb', 'resource', 'layout', 'blocks',
    ];

    protected $casts = [
        'verb' => PageVerb::class,
    ];

    public function isAdvanced(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => $this->resource !== null
        );
    }

    public function isBasic(): Attribute
    {
        return Attribute::make(
            get: fn (): bool => $this->resource === null
        );
    }

    public function getActivitylogOptions(): LogOptions
    {
        $logOptions = LogOptions::defaults()->logFillable();

        if (app('impersonate')->isImpersonating()) {
            return $logOptions->useLogName('impersonation')
                ->setDescriptionForEvent(
                    fn (string $eventName): string => ":subject.key page was {$eventName} during impersonation by ".app('impersonate')->getImpersonator()->name
                );
        }

        return $logOptions
            ->setDescriptionForEvent(
                fn (string $eventName): string => ":subject.key page was {$eventName}"
            );
    }

    public function newCollection(array $models = []): PagesCollection
    {
        return new PagesCollection($models);
    }

    public function newEloquentBuilder($query): Builders\PageBuilder
    {
        return new Builders\PageBuilder($query);
    }
}
