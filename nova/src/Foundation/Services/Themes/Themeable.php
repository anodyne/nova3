<?php namespace Nova\Foundation\Services\Themes;

use Page;

interface Themeable {

	/**
	 * Build the theme structure.
	 *
	 * @param 	string	$view 	The view file to use
	 * @param 	array 	$data 	Data to pass to the structure
	 * @return 	Theme
	 */
	public function structure($view, array $data);

	/**
	 * Build the theme template.
	 *
	 * @param 	string	$view 	The view file to use
	 * @param 	array 	$data 	Data to pass to the template
	 * @return 	Theme
	 * @throws	NoThemeStructureException
	 */
	public function template($view, array $data);
	
	/**
	 * Build the theme menu.
	 *
	 * @param 	Page	$page 	The current page
	 * @return 	Theme
	 * @throws	NoThemeTemplateException
	 */
	public function menu(Page $page);

	/**
	 * Build the theme admin menu.
	 *
	 * @param 	Page	$page 	The current page
	 * @return 	Theme
	 * @throws	NoThemeTemplateException
	 */
	public function adminMenu(Page $page);

	/**
	 * Build the theme footer.
	 *
	 * @param 	array 	$data 	Data to pass to the footer
	 * @return 	Theme
	 * @throws	NoThemeTemplateException
	 */
	public function footer(array $data = []);

	/**
	 * Build the page.
	 *
	 * @param 	string	$view 	The view file to use
	 * @param 	array 	$data 	Data to pass to the page
	 * @return 	Theme
	 * @throws	NoThemeTemplateException
	 */
	public function page($view, array $data);

	/**
	 * Build the Javascript for the page.
	 *
	 * @param 	string	$view 	The view file to use
	 * @param 	array 	$data 	Data to pass to the Javascript view
	 * @return 	Theme
	 * @throws	NoThemeTemplateException
	 */
	public function javascript($view, array $data);
	public function alerts(array $data);
	public function ajax(array $data);
	public function styles($view, array $data);
	public function panel();

	/**
	 * Return the View object with the complete template for rendering.
	 *
	 * @return 	View
	 */
	public function render();

	public function setData($key, $data);
	public function setView($key, $file);

	/**
	 * Get a specific icon out of the theme's icon map.
	 *
	 * @param	string
	 * @return	string
	 * @throws	Exception
	 */
	public function getIcon($icon);
	
	/**
	 * Get the theme icon map.
	 *
	 * @return	array
	 */
	public function getIconMap();
}