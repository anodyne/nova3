<?php namespace Nova\Foundation\Services;

use Illuminate\Http\Request;
use Dingo\Api\{Routing\Route, Contract\Auth\Provider};
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class LaravelApiProvider implements Provider {

	public function authenticate(Request $request, Route $route)
	{
		dd($request, $route, auth('api')->check());
		return auth()->guard('api')->user();

		throw new UnauthorizedHttpException('Unable to authenticate with supplied user.');
	}

}
