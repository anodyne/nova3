<?php

declare(strict_types=1);

namespace Nova\Forms\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Nova\Forms\Enums\FormType;
use Nova\Forms\Models\Form;
use Nova\Foundation\Models\Builders\Concerns\QueriesStatus;

/**
 * @template TModel of Form
 *
 * @extends Builder<TModel>
 */
class FormBuilder extends Builder
{
    use QueriesStatus;

    public function basic(): self
    {
        return $this->where('type', FormType::Basic);
    }

    public function key(string $key): self
    {
        return $this->where('key', $key);
    }

    public function searchFor($search): self
    {
        return $this->whereAny([
            'name',
            'key',
            'description',
        ], 'like', "%{$search}%");
    }

    public function submissible(): self
    {
        return $this->where('type', FormType::Basic)
            ->where('options->singleSubmission', false)
            ->orWhere(fn (Builder $query): Builder => $query->where('options->singleSubmission', true)
                ->whereDoesntHave('submissions', fn ($q) => $q->where('owner_type', 'user')->where('owner_id', Auth::id())));
    }
}
