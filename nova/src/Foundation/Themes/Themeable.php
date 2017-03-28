<?php namespace Nova\Foundation\Themes;

use Page;
use MenuItem;

interface Themeable
{
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
	 * @param 	array 	$scripts Scripts to be loaded
	 * @return 	Theme
	 * @throws	NoThemeStructureException
	 */
	public function javascript(array $scripts);
	public function alerts(array $data);
	public function ajax(array $data);
	public function styles(array $styles);
	public function panel();

	/**
	 * Return the View object with the complete template for rendering.
	 *
	 * @return 	View
	 */
	public function render();

	public function setData($key, $data);
	public function setView($key, $file);

	public function buildMainMenu();
	public function buildSubMenu(Page $page);
	public function buildCombinedMenu();
	public function buildMenuItem(MenuItem $item);

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
