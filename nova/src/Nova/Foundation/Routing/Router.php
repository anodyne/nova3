<?php
/**
 * Overrides the default Router so that we can try to find
 * where something is located and route to there automatically.
 *
 * @package		Nova
 * @subpackage	Foundation
 * @category	Class
 * @author		Anodyne Productions
 * @copyright	2012 Anodyne Productions
 */

namespace Nova\Foundation\Routing;

use Request as LaravelRequest;
use ReflectionClass;
use Illuminate\Routing\Route;
use Illuminate\Routing\Router as lRouter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Router extends lRouter {

	/**
	 * The naming convention used for controllers.
	 */
	protected $novaControllerNamePattern = 'Controller\\{name}';

	/**
	 * The default controller.
	 */
	protected $novaControllerDefault = 'main';

	/**
	 * The naming convention used for controller actions.
	 */
	protected $novaActionNamePattern = 'action{name}';

	/**
	 * The default action for a controller.
	 */
	protected $novaActionDefault = 'index';

	/**
	 * The paths to check.
	 */
	protected $novaCoreNamespaces = array(
		'Nova\\Core',
		'Nova\\Wiki',
		'Nova\\Forum',
	);

	/**
	 * Namespaces used in checking.
	 */
	protected $novaNonCoreNamespaces = array(
		'app'		=> 'App\\',
		'module'	=> 'Module\\',
	);

	/**
	 * The controller the Route is using.
	 */
	protected $controller;

	/**
	 * The action method the Route is using.
	 */
	protected $action;

	/**
	 * A holding array for remaining segments.
	 */
	protected $uriSegments;

	/**
	 * Match the given request to a route object.
	 *
	 * @param  Symfony\Component\HttpFoundation\Request  $request
	 * @return Illuminate\Routing\Route
	 */
	protected function findRoute(Request $request)
	{
		// We will catch any exceptions thrown during routing and convert it to a
		// HTTP Kernel equivalent exception, since that is a more generic type
		// that's used by the Illuminate foundation framework for responses.
		try
		{
			$path = '/'.trim($request->getPathInfo(), '/');

			$this->parsePath($path);

			$parameters = $this->getUrlMatcher($request)->match($path);
		}

		// The Symfony routing component's exceptions implement this interface we
		// can type-hint it to make sure we're only providing special handling
		// for those exceptions, and not other random exceptions that occur.
		catch (ExceptionInterface $e)
		{
			$this->handleRoutingException($e);
		}

		$route = $this->routes->get($parameters['_route']);

		// If we found a route, we will grab the actual route objects out of this
		// route collection and set the matching parameters on the instance so
		// we will easily access them later if the route action is executed.
		$route->setParameters($parameters);

		$route->setRouter($this);

		return $route;
	}

	/**
	 * Parse the path so we don't have to explicitly route.
	 *
	 * @param	string	The request path
	 * @return	bool|void
	 * @throws	NotFoundHttpException
	 *
	 * @todo	Remove debug calls
	 */
	protected function parsePath($path)
	{
		// Get the path as an array
		$this->uriSegments = explode('/', substr_replace($path, '', 0, 1));

		// Build the controller name
		$controllerName = $this->buildControllerName($this->uriSegments);

		$this->debug('Final Controller Name: '.$controllerName);

		// No controller found, let the Router check explicit routes
		if ( ! $controllerName)
		{
			return false;
		}

		// Set the controller in the Router
		$this->controller = strtolower($controllerName);

		// Start to build the full route
		$route = $controllerName;

		// Use reflection to get information about the class
		$class = new ReflectionClass($controllerName);

		// Build the action name
		$actionName = $this->buildActionName();

		$this->debug('Final Action Name: '.$actionName);

		// If we don't have the action method, throw a 404
		if ( ! $class->hasMethod($actionName))
		{
			throw new NotFoundHttpException;
		}

		// Split out the action from the pattern
		$actionPrefix = str_replace('{name}', '', $this->novaActionNamePattern);

		// Set the action in the Router
		$this->action = strtolower(str_replace($actionPrefix, '', $actionName));

		// Build the rest of the route with the found action
		$route.= '@'.$actionName;

		$this->debug('Final Route: '.$route);

		// Start a string for any parameters
		$paramString = '';

		// Loop through the remaining segments
		foreach ($this->uriSegments as $s)
		{
			$paramString.= '{any}/';
		}

		// Take the remaining URI segments and make them a string
		$segmentString = implode('/', $this->uriSegments);

		// Swap out the segments for wildcards
		$path = str_replace($segmentString, $paramString, $path);

		// Now trim the path to make sure we don't have pesky slashes in there
		$path = trim($path, '/');

		// Create the route
		$this->createRoute(strtolower(LaravelRequest::getMethod()), $path, $route);
	}

	/**
	 * Find and return the proper controller.
	 *
	 * @return	string|bool
	 *
	 * @todo	Remove debug calls
	 */
	protected function buildControllerName(array $segments)
	{
		if (count($segments) > 0)
		{
			// Set the namespace before we start
			$namespace = '';

			// Loop through the segments and try to find the controller
			foreach ($segments as $segment)
			{
				if (empty($segment))
				{
					// No segments, so use the default
					return $this->buildControllerName(array($this->novaControllerDefault));
				}

				// Find the controller
				$find = $this->findController($namespace.ucfirst($segment));

				// We didn't find it
				if ($find === false)
				{
					// Append the segment to the namespace
					$namespace.= ucfirst($segment).'\\';
				}
				else
				{
					$this->debug('Found: '.$find);

					// Build the path segments we're using
					$pathSegments = str_replace('\\\\', '/', strtolower($namespace).'\\'.$segment);

					// Build the new path
					$newPath = trim(str_replace($pathSegments, '', LaravelRequest::path()), '/');

					// Update the URI segments
					$this->uriSegments = explode('/', $newPath);

					// Found the controller
					return $find;
				}

				$this->debug('===============');
			}

			return false;
		}

		// No segments, so use the default
		return $this->buildControllerName(array($this->novaControllerDefault));
	}

	/**
	 * Run through the app, modules and core to find the controller.
	 *
	 * @param	string	A path segment to check
	 * @return	string|bool
	 *
	 * @todo	Remove debug calls
	 */
	protected function findController($segment)
	{
		// Use the pattern to build the class name
		$controller = str_replace('{name}', ucfirst($segment), $this->novaControllerNamePattern);

		// Build the namespace for app controllers
		$appController = $this->novaNonCoreNamespaces['app'].$controller;
		$this->debug($appController);

		// Does this controller exist in the app?
		if (class_exists($appController))
		{
			return $appController;
		}

		// Get the list of active modules
		$modules = \Cache::get('nova_module_list', array());

		// Does this controller exist in any of the modules?
		foreach ($modules as $m)
		{
			// Build the namespace for the module controllers
			$moduleController = $this->novaNonCoreNamespaces['module'].ucfirst($m).'\\'.$controller;
			$this->debug($moduleController);

			// Does this controller exist in the module?
			if (class_exists($moduleController))
			{
				return $moduleController;
			}
		}
		
		// It's not in the app or the modules, so rip through the Nova namespaces and check there
		foreach ($this->novaCoreNamespaces as $n)
		{
			// Build the namespace for the core controllers
			$coreController = $n.'\\'.$controller;
			$this->debug($coreController);

			if (class_exists($coreController))
			{
				return $coreController;
			}
		}
		
		return false;
	}

	/**
	 * Use the action pattern and build the full action name.
	 *
	 * @return	string
	 */
	protected function buildActionName()
	{
		$action = (isset($this->uriSegments[0]))
			? str_replace('{name}', ucfirst($this->uriSegments[0]), $this->novaActionNamePattern)
			: str_replace('{name}', ucfirst($this->novaActionDefault), $this->novaActionNamePattern);

		// Remove the first element from the array
		array_shift($this->uriSegments);

		return $action;
	}

	protected function debug($var)
	{
		$show = false;

		if ($show)
		{
			echo '<pre>';
			var_dump($var);
			echo '</pre>';
		}
	}

	public function getController()
	{
		return $this->controller;
	}

	public function getAction()
	{
		return $this->action;
	}
}
