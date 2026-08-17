<?php

declare(strict_types=1);

namespace Nova\Forms\Models;

use Carbon\CarbonImmutable;
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
 * @method static \Database\Factories\FormFieldFactory factory($count = null, $state = [])
 * @method static \Nova\Forms\Models\Builders\FormFieldBuilder<static>|\Nova\Forms\Models\FormField form(\Nova\Forms\Models\Form|int $form)
 * @method static \Nova\Forms\Models\Builders\FormFieldBuilder<static>|\Nova\Forms\Models\FormField newModelQuery()
 * @method static \Nova\Forms\Models\Builders\FormFieldBuilder<static>|\Nova\Forms\Models\FormField newQuery()
 * @method static \Nova\Forms\Models\Builders\FormFieldBuilder<static>|\Nova\Forms\Models\FormField ordered(string $direction = 'asc')
 * @method static \Nova\Forms\Models\Builders\FormFieldBuilder<static>|\Nova\Forms\Models\FormField query()
 * @method static \Nova\Forms\Models\Builders\FormFieldBuilder<static>|\Nova\Forms\Models\FormField uid(string $uid)
 * @method static \Nova\Forms\Models\Builders\FormFieldBuilder<static>|\Nova\Forms\Models\FormField whereCreatedAt($value)
 * @method static \Nova\Forms\Models\Builders\FormFieldBuilder<static>|\Nova\Forms\Models\FormField whereFormId($value)
 * @method static \Nova\Forms\Models\Builders\FormFieldBuilder<static>|\Nova\Forms\Models\FormField whereId($value)
 * @method static \Nova\Forms\Models\Builders\FormFieldBuilder<static>|\Nova\Forms\Models\FormField whereLabel($value)
 * @method static \Nova\Forms\Models\Builders\FormFieldBuilder<static>|\Nova\Forms\Models\FormField whereName($value)
 * @method static \Nova\Forms\Models\Builders\FormFieldBuilder<static>|\Nova\Forms\Models\FormField whereOrderColumn($value)
 * @method static \Nova\Forms\Models\Builders\FormFieldBuilder<static>|\Nova\Forms\Models\FormField whereType($value)
 * @method static \Nova\Forms\Models\Builders\FormFieldBuilder<static>|\Nova\Forms\Models\FormField whereUid($value)
 * @method static \Nova\Forms\Models\Builders\FormFieldBuilder<static>|\Nova\Forms\Models\FormField whereUpdatedAt($value)
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
