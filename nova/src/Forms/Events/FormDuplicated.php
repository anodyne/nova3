<?php

declare(strict_types=1);

namespace Nova\Forms\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Nova\Forms\Models\Form;

class FormDuplicated
{
    use Dispatchable;
    use SerializesModels;

    public Form $original;

    public Form $form;

    public function __construct(Form $form, Form $original)
    {
        $this->original = $original;
        $this->form = $form;
    }
}
