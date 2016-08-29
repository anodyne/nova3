<?php namespace Nova\Api\V1\Controllers;

use Dingo\Api\Routing\Helpers;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpKernel\Exception;

abstract class ApiBaseController extends Controller {

	use Helpers;

	/**
	 * 403 Access Denied
	 */
	public function errorAccessDenied($message = false)
	{
		throw new Exception\AccessDeniedHttpException($message);
	}

	/**
	 * 404 Not Found
	 */
	public function errorNotFound($message = false)
	{
		throw new Exception\NotFoundHttpException($message);
	}

	/**
	 * 401 Unauthorized
	 */
	public function errorUnauthorized($message = false)
	{
		throw new Exception\UnauthorizedHttpException($message);
	}
}
