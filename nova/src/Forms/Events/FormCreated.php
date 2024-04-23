<?php

declare(strict_types=1);

namespace Nova\Forms\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Nova\Forms\Models\Form;

class FormCreated
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(
        public Form $form
    ) {
    }
}
