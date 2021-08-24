<?php

declare(strict_types=1);

namespace Nova\Foundation\Controllers;

class WelcomeController extends Controller
{
    public function __invoke()
    {
        return view('pages.welcome');
    }
}
