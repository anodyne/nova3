<?php

declare(strict_types=1);

namespace Nova\Forms\Enums;

enum FormSubmissionMode: string
{
    case Create = 'create';

    case Edit = 'edit';
}
