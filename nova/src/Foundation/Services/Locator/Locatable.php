<?php namespace Nova\Foundation\Services\Locator;

interface Locatable {

	/**
	 * Search for an ajax view file.
	 *
	 * @param	string	$file	The file to find (no extension)
	 * @return	string
	 */
	public function ajax($file);

	/**
	 * Check to see if an ajax view file exists.
	 *
	 * @param	string	$file	The file to find (no extension)
	 * @return	bool
	 */
	public function ajaxExists($file);

	/**
	 * Search for an email view file.
	 *
	 * @param	string	$file	The file to find (no extension)
	 * @return	string
	 */
	public function email($file);

	/**
	 * Check to see if an email view file exists.
	 *
	 * @param	string	$file	The file to find (no extension)
	 * @return	bool
	 */
	public function emailExists($file);

	/**
	 * Search for an error view file.
	 *
	 * @param	string	$file	The file to find (no extension)
	 * @return	string
	 */
	public function error($file);

	/**
	 * Check to see if an error view file exists.
	 *
	 * @param	string	$file	The file to find (no extension)
	 * @return	bool
	 */
	public function errorExists($file);

	/**
	 * Check to see if a view file exists.
	 *
	 * @param	string	$type	The type of file to find
	 * @param	string	$file	The file to find (no extension)
	 * @return	bool
	 */
	public function exists($type, $file);

	/**
	 * Search for an image file.
	 *
	 * @param	string	$image	The image to find
	 * @return	string
	 */
	public function image($image);

	/**
	 * Check to see if an image exists.
	 *
	 * @param	string	$image	The image to find
	 * @return	bool
	 */
	public function imageExists($image): bool;

	/**
	 * Search for a javascript view file.
	 *
	 * @param	string	$file	The file to find (no extension)
	 * @return	string
	 */
	public function javascript($file);

	/**
	 * Check to see if a javascript view file exists.
	 *
	 * @param	string	$file	The file to find (no extension)
	 * @return	bool
	 */
	public function javascriptExists($file);

	/**
	 * Search for a page view file.
	 *
	 * @param	string	$file	The file to find (no extension)
	 * @return	string
	 */
	public function page($file);

	/**
	 * Check to see if a page view file exists.
	 *
	 * @param	string	$file	The file to find (no extension)
	 * @return	bool
	 */
	public function pageExists($file);

	/**
	 * Search for a partial view file.
	 *
	 * @param	string	$file	The file to find (no extension)
	 * @return	string
	 */
	public function partial($file);

	/**
	 * Check to see if a partial view file exists.
	 *
	 * @param	string	$file	The file to find (no extension)
	 * @return	bool
	 */
	public function partialExists($file);

	/**
	 * Search for a structure view file.
	 *
	 * @param	string	$file	The file to find (no extension)
	 * @return	string
	 */
	public function structure($file);

	/**
	 * Check to see if a structure view file exists.
	 *
	 * @param	string	$file	The file to find (no extension)
	 * @return	bool
	 */
	public function structureExists($file);

	/**
	 * Search for a style view file.
	 *
	 * @param	string	$file	The file to find (no extension)
	 * @return	string
	 */
	public function style($file);

	/**
	 * Check to see if a style view file exists.
	 *
	 * @param	string	$file	The file to find (no extension)
	 * @return	bool
	 */
	public function styleExists($file);

	/**
	 * Search for an SVG file.
	 *
	 * @param	string	$image	The image to find
	 * @return	string
	 */
	public function svg($image);

	/**
	 * Check to see if an SVG exists.
	 *
	 * @param	string	$image	The image to find
	 * @return	bool
	 */
	public function svgExists($image): bool;

	/**
	 * Search for a template view file.
	 *
	 * @param	string	$file	The file to find (no extension)
	 * @return	string
	 */
	public function template($file);

	/**
	 * Check to see if a template view file exists.
	 *
	 * @param	string	$file	The file to find (no extension)
	 * @return	bool
	 */
	public function templateExists($file);

	/**
	 * Register a new search path for the locator.
	 *
	 * @param	string	$path
	 * @return	void
	 */
	public function registerSearchPath($path);
}
