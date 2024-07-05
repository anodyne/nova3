<?php

declare(strict_types=1);

namespace Nova\Forms\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Forms\Enums\FormStatus;
use Nova\Forms\Enums\FormType;

class FormBuilder extends Builder
{
    public function active(): Builder
    {
        return $this->where('status', FormStatus::Active);
    }

    public function basic(): Builder
    {
        return $this->where('type', FormType::Basic);
    }

    public function key(string $key): Builder
    {
        return $this->where('key', $key);
    }

    public function searchFor($search): Builder
    {
        return $this->whereAny([
            'name',
            'key',
            'description',
        ], 'like', "%{$search}%");
    }

    public function submissible(): Builder
    {
        return $this->where('type', FormType::Basic)
            ->where('options->singleSubmission', false)
            ->orWhere(function (Builder $query): Builder {
                return $query->where('options->singleSubmission', true)
                    ->whereDoesntHave('submissions', fn ($q) => $q->where('owner_type', 'user')->where('owner_id', auth()->id()));
            });
    }
}
