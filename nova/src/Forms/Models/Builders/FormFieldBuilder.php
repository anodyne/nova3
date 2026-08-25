<?php

declare(strict_types=1);

namespace Nova\Forms\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Forms\Models\Form;
use Nova\Forms\Models\FormField;

/**
 * @extends Builder<FormField>
 */
class FormFieldBuilder extends Builder
{
    public function form(Form|int $form): self
    {
        return $this->where('form_id', $form->id ?? $form);
    }

    public function uid(string $uid): self
    {
        return $this->where('uid', $uid);
    }
}
