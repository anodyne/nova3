<?php

declare(strict_types=1);

namespace Nova\Forms\Models;

use Illuminate\Database\Eloquent\Attributes\UseEloquentBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Nova\Forms\Models\Builders\FormFieldBuilder;
use Nova\Foundation\Concerns\LogsActivity;
use Nova\Foundation\Concerns\SortableTrait;
use Nova\Foundation\Models\Model;
use Spatie\EloquentSortable\Sortable;

/**
 * @mixin IdeHelperFormField
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
