<?php

declare(strict_types=1);

namespace Nova\Pages\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Nova\Media\Concerns\InteractsWithMedia;
use Nova\Pages\Enums\PageStatus;
use Nova\Pages\Enums\PageVerb;
use Nova\Pages\Events;
use Nova\Pages\Models\Collections\PagesCollection;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;

class Page extends Model implements HasMedia
{
    use InteractsWithMedia;
    use LogsActivity;

    protected $fillable = [
        'name', 'uri', 'key', 'verb', 'resource', 'layout', 'blocks', 'published_blocks', 'status', 'middleware',
    ];

    protected $casts = [
        'blocks' => 'array',
        'middleware' => 'array',
        'published_at' => 'datetime',
        'published_blocks' => 'array',
        'status' => PageStatus::class,
        'verb' => PageVerb::class,
    ];

    protected $dispatchesEvents = [
        'created' => Events\PageCreated::class,
        'deleted' => Events\PageDeleted::class,
        'updated' => Events\PageUpdated::class,
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

    public function isPreviewable(): Attribute
    {
        return Attribute::make(
            get: function (): bool {
                if (filled($this->blocks) && blank($this->published_blocks)) {
                    return true;
                }

                if ($this->blocks !== $this->published_blocks) {
                    return true;
                }

                return false;
            }
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

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('block-images')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'])
            ->useDisk('media');
    }

    public static function getMediaPath(): string
    {
        return 'pages/{model_id}/{media_id}/';
    }
}
