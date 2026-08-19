<?php

declare(strict_types=1);

namespace Nova\Forms\Models;

use Carbon\CarbonImmutable;
use Database\Factories\FormFieldFactory;
use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nova\Forms\Models\Builders\FormFieldBuilder;
use Nova\Foundation\Concerns\LogsActivity;
use Nova\Foundation\Concerns\SortableTrait;
use Nova\Foundation\Models\Model;
use Spatie\Activitylog\Models\Activity;
use Spatie\EloquentSortable\Sortable;

/**
 * @property int $id
 * @property int $form_id
 * @property string $name
 * @property string $uid
 * @property string $label
 * @property string $type
 * @property int|null $order_column
 * @property CarbonImmutable|null $created_at
 * @property CarbonImmutable|null $updated_at
 * @property-read Collection<int, Activity> $activities
 * @property-read int|null $activities_count
 * @property-read Form $form
 * @property-read Collection<int, FormSubmissionResponse> $responses
 * @property-read int|null $responses_count
 *
 * @method static FormFieldFactory factory($count = null, $state = [])
 * @method static FormFieldBuilder<static>|FormField form(Form|int $form)
 * @method static FormFieldBuilder<static>|FormField newModelQuery()
 * @method static FormFieldBuilder<static>|FormField newQuery()
 * @method static FormFieldBuilder<static>|FormField ordered(string $direction = 'asc')
 * @method static FormFieldBuilder<static>|FormField query()
 * @method static FormFieldBuilder<static>|FormField uid(string $uid)
 * @method static FormFieldBuilder<static>|FormField whereCreatedAt($value)
 * @method static FormFieldBuilder<static>|FormField whereFormId($value)
 * @method static FormFieldBuilder<static>|FormField whereId($value)
 * @method static FormFieldBuilder<static>|FormField whereLabel($value)
 * @method static FormFieldBuilder<static>|FormField whereName($value)
 * @method static FormFieldBuilder<static>|FormField whereOrderColumn($value)
 * @method static FormFieldBuilder<static>|FormField whereType($value)
 * @method static FormFieldBuilder<static>|FormField whereUid($value)
 * @method static FormFieldBuilder<static>|FormField whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
#[UseEloquentBuilder(FormFieldBuilder::class)]
class FormField extends Model implements Sortable
{
    use HasFactory;
    use LogsActivity;
    use SortableTrait;

    protected $fillable = [
        'form_id',
        'name',
        'uid',
        'label',
        'type',
        'order_column',
    ];

    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class);
    }

    public function responses(): HasMany
    {
        return $this->hasMany(FormSubmissionResponse::class, 'field_uid', 'uid');
    }
}
