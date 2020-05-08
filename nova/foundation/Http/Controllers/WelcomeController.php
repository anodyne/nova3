<?php

namespace Nova\Foundation\Http\Controllers;

class WelcomeController extends Controller
{
    public function __invoke()
    {
        return view('pages.welcome');
    }
}
