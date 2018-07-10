<?php

namespace Nova\Tokens\Http\Controllers;

use Nova\Foundation\Http\Controllers\Controller;

class TokensController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->middleware('auth');

		$this->views('basic', 'template');
		$this->views('app-sidebar', 'layout');
	}

    public function handle()
	{
		$this->views('tokens.index', 'page|script');
	}
}
