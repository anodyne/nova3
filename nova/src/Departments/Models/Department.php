<?php

namespace Nova\Departments\Models;

use Nova\Departments\Events;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Nova\Departments\Models\Builders\DepartmentBuilder;

class Department extends Model implements HasMedia
{
    use HasMediaTrait;
    use LogsActivity;

    public const MEDIA_DIRECTORY = 'departments/{model_id}/{media_id}/';

    protected static $logFillable = true;

    protected static $logName = 'admin';

    protected $casts = [
        'active' => 'boolean',
        'sort' => 'integer',
    ];

    protected $dispatchesEvents = [
        'created' => Events\DepartmentCreated::class,
        'deleted' => Events\DepartmentDeleted::class,
        'updated' => Events\DepartmentUpdated::class,
    ];

    protected $fillable = ['name', 'description', 'sort', 'active'];

    protected $table = 'departments';

    public function positions()
    {
        return $this->hasMany(Position::class)->orderBySort();
    }

    public function getDescriptionForEvent(string $eventName): string
    {
        return ":subject.name department was {$eventName}";
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
