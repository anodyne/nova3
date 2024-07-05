<?php

declare(strict_types=1);

namespace Nova\Forms\Models\Builders;

use Illuminate\Database\Eloquent\Builder;
use Nova\Forms\Models\Form;

class FormFieldBuilder extends Builder
{
    public function form(Form|int $form): Builder
    {
        return $this->where('form_id', is_int($form) ? $form : $form->id);
    }

    public function uid(string $uid): Builder
    {
        return $this->where('uid', $uid);
    }
}
