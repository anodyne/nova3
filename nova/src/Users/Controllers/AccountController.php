<?php

declare(strict_types=1);

namespace Nova\Users\Controllers;

use Nova\Foundation\Controllers\Controller;
use Nova\Users\Responses\EditUserAccountResponse;

class AccountController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function edit()
    {
        return EditUserAccountResponse::sendWith([
            'user' => auth()->user(),
        ]);
    }

    public function update()
    {
    }
}
