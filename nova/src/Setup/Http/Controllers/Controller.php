<?php namespace Nova\Setup\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
	protected $setupType;

	public function __construct()
	{
		$this->middleware(function ($request, $next) {
			// Set the current user on the controller
			$this->setupType = $request->segment(2);

			// Share the setup type with every view that's created
			view()->share('_setupType', $this->setupType);

			return $next($request);
		});
	}
}