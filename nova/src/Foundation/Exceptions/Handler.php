<?php namespace Nova\Foundation\Exceptions;

use Exception;
use Illuminate\Auth\AuthenticationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		\Illuminate\Auth\AuthenticationException::class,
		\Illuminate\Auth\Access\AuthorizationException::class,
		\Symfony\Component\HttpKernel\Exception\HttpException::class,
		\Illuminate\Database\Eloquent\ModelNotFoundException::class,
		\Illuminate\Session\TokenMismatchException::class,
		\Illuminate\Validation\ValidationException::class,
	];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception  $exception
	 * @return void
	 */
	public function report(Exception $exception)
	{
		parent::report($exception);

		// Set some defaults so we don't bomb out
		$errorCode = 0;
		$logMessage = "An error occurred";

		// 404 error
		if ($exception instanceof NotFoundHttpException) {
			$errorCode = $exception->getStatusCode();
	        $logMessage = 'Page not found [/'.request()->path().']';
	    }

	    // Log authentication errors
	    if ($exception instanceof AuthenticationException) {
	    	$errorCode = 403;
	    	$logMessage = 'An unauthenticated user attempted to access a page that requires authentication';
	    }

	    // Log authorization errors

	    if ($exception instanceof HttpException) {
			$errorCode = $exception->getStatusCode();
	    }

		activity('nova-error')
			->withProperties([
				'code' => $errorCode,
				'ip_address' => request()->ip(),
				'message' => $exception->getMessage(),
				'uri' => request()->path(),
			])
			->log($logMessage);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Exception  $exception
	 * @return \Illuminate\Http\Response
	 */
	public function render($request, Exception $exception)
	{
		return parent::render($request, $exception);
	}

	/**
	 * Convert an authentication exception into an unauthenticated response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Illuminate\Auth\AuthenticationException  $exception
	 * @return \Illuminate\Http\Response
	 */
	protected function unauthenticated($request, AuthenticationException $exception)
	{
		if ($request->expectsJson()) {
			return response()->json(['error' => 'Unauthenticated.'], 401);
		}

		return redirect()->guest(route('sign-in'));
	}
}
