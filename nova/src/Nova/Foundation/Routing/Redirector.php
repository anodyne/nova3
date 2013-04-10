<?php namespace Nova\Foundation\Routing;

/**
 * Redirector override.
 *
 * @package		Nova
 * @subpackage	Foundation
 * @category	Class
 * @author		Anodyne Productions
 * @copyright	2013 Anodyne Productions
 */

use Illuminate\Routing\Redirector as LaravelRedirector;

class Redirector extends LaravelRedirector {

	/**
	 * Create a new redirect response to the given path.
	 *
	 * @param  string  $path
	 * @param  int     $status
	 * @param  array   $headers
	 * @param  bool    $secure
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function to($path, $status = 302, $headers = array(), $secure = null)
	{
		return parent::to($path, $status, $headers, $secure)->setContent('');
	}

}