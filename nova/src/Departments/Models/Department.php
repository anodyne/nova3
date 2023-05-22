<?php

declare(strict_types=1);

namespace Nova\Departments\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Nova\Departments\Enums\DepartmentStatus;
use Nova\Departments\Events;
use Nova\Departments\Models\Builders\DepartmentBuilder;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Department extends Model implements HasMedia, Sortable
{
    use HasFactory;
    use InteractsWithMedia;
    use LogsActivity;
    use SortableTrait;

    public const MEDIA_DIRECTORY = 'departments/{model_id}/{media_id}/';

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
        return LogOptions::defaults()
            ->logFillable()
            ->useLogName('admin')
            ->setDescriptionForEvent(
                fn (string $eventName) => ":subject.name department was {$eventName}"
            );
    }

    public function newEloquentBuilder($query): DepartmentBuilder
    {
        return new DepartmentBuilder($query);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('department-header')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif'])
            ->singleFile();
    }
}
