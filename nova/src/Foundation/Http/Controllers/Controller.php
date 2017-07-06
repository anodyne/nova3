<?php namespace Nova\Foundation\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
	use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	protected $user;

	public function __construct()
	{
		$this->middleware(function ($request, $next) {
			// Set the current user on the controller
			$this->_user = $request->user();

			// Share the current user with every view
			view()->share('_user', $request->user());

			return $next($request);
		});
	}
}
