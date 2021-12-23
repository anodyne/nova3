<?php

declare(strict_types=1);

namespace Nova\Forms\Actions;

use Lorisleiva\Actions\Concerns\AsAction;
use Nova\Forms\Data\FormData;
use Nova\Forms\Models\Form;

class CreateForm
{
    use AsAction;

    public function handle(FormData $data): Form
    {
        return Form::create($data->all());
    }
}
