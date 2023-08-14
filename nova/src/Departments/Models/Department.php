<?php

declare(strict_types=1);

namespace Nova\Departments\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nova\Departments\Enums\DepartmentStatus;
use Nova\Departments\Events;
use Nova\Departments\Models\Builders\DepartmentBuilder;
use Nova\Media\Concerns\InteractsWithMedia;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\HasMedia;

class Department extends Model implements HasMedia, Sortable
{
    use HasFactory;
    use InteractsWithMedia;
    use LogsActivity;
    use SortableTrait;

    protected $casts = [
        'order_column' => 'integer',
        'status' => DepartmentStatus::class,
    ];

    protected $dispatchesEvents = [
        'created' => Events\DepartmentCreated::class,
        'deleted' => Events\DepartmentDeleted::class,
        'updated' => Events\DepartmentUpdated::class,
    ];

    protected $fillable = ['name', 'description', 'order_column', 'status'];

    protected $table = 'departments';

    public function positions()
    {
        return $this->hasMany(Position::class)->ordered();
    }

    public function getActivitylogOptions(): LogOptions
    {
        $logOptions = LogOptions::defaults()->logFillable();

        if (app('impersonate')->isImpersonating()) {
            return $logOptions->useLogName('impersonation')
                ->setDescriptionForEvent(
                    fn (string $eventName): string => ":subject.name department was {$eventName} during impersonation by ".app('impersonate')->getImpersonator()->name
                );
        }

        return $logOptions
            ->setDescriptionForEvent(
                fn (string $eventName): string => ":subject.name department was {$eventName}"
            );
    }

    public function newEloquentBuilder($query): DepartmentBuilder
    {
        return new DepartmentBuilder($query);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('header')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'])
            ->singleFile()
            ->useDisk('media');
    }

    public static function getMediaPath(): string
    {
        return 'departments/{model_id}/{media_id}/';
    }
}
