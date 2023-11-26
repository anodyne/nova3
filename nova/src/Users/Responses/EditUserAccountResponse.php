<?php

declare(strict_types=1);

namespace Nova\Users\Responses;

use Nova\Foundation\Responses\Responsable;

class EditUserAccountResponse extends Responsable
{
    public ?string $subnav = null;

    public string $view = 'users.account';
}
