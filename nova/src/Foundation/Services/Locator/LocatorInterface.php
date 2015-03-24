<?php namespace Nova\Foundation\Services\Locator;

interface LocatorInterface {

	/**
	 * Search for an ajax view file.
	 *
	 * @param	string	$file	The file to find (no extension)
	 * @return	string
	 */
	public function ajax($file);

	/**
	 * Search for an email view file.
	 *
	 * @param	string	$file	The file to find (no extension)
	 * @return	string
	 */
	public function email($file);

	/**
	 * Search for an error view file.
	 *
	 * @param	string	$file	The file to find (no extension)
	 * @return	string
	 */
	public function error($file);

	/**
	 * Search for a javascript view file.
	 *
	 * @param	string	$file	The file to find (no extension)
	 * @return	string
	 */
	public function javascript($file);

	/**
	 * Search for a page view file.
	 *
	 * @param	string	$file	The file to find (no extension)
	 * @return	string
	 */
	public function page($file);

	/**
	 * Search for a partial view file.
	 *
	 * @param	string	$file	The file to find (no extension)
	 * @return	string
	 */
	public function partial($file);

	/**
	 * Search for a structure view file.
	 *
	 * @param	string	$file	The file to find (no extension)
	 * @return	string
	 */
	public function structure($file);

	/**
	 * Search for a style view file.
	 *
	 * @param	string	$file	The file to find (no extension)
	 * @return	string
	 */
	public function style($file);

	/**
	 * Search for a template view file.
	 *
	 * @param	string	$file	The file to find (no extension)
	 * @return	string
	 */
	public function template($file);

	/**
	 * Register a new search path for the locator.
	 *
	 * @param	string	$path
	 * @return	void
	 */
	public function registerSearchPath($path);

}
