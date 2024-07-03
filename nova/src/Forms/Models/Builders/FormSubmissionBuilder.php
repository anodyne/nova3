<?php

declare(strict_types=1);

namespace Nova\Forms\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Forms\Models\Form;

class FormSubmissionBuilder extends Builder
{
    public function form(Form|int $form): Builder
    {
        return $this->where('form_id', $form?->id ?? $form);
    }
}
