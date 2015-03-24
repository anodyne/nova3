<?php namespace Nova\Foundation\Services\Themes;

use Page;
use Illuminate\Contracts\Foundation\Application;

class Theme implements Themeable, ThemeableInfo {

	protected $app;
	protected $name;
	protected $view;
	protected $author;
	protected $layout;
	protected $locate;
	protected $credits;
	protected $preview;
	protected $version;
	protected $location;

	protected $data = [];
	protected $views = [];

	public function __construct($themeName, Application $app)
	{
		// Grab the JSON file and parse it
		$theme = json_decode(file_get_contents($app->themePath($themeName).'/theme.json'));

		// Assign the remaining properties
		$this->app 		= $app;
		$this->view 	= $app['view'];
		$this->locate 	= $app['nova.locator'];
		$this->name 	= $theme->name;
		$this->author	= $theme->author;
		$this->credits 	= $theme->credits;
		$this->preview 	= $theme->preview;
		$this->version 	= $theme->version;
		$this->location = $theme->location;

		// Allow for some initializing
		$this->initialize();
	}

	/**
	 * Method that allows for doing some initialization work for the theme that
	 * doesn't require overriding the class constructor. This is called after
	 * everything else in the constructor is called.
	 *
	 * @return	void
	 */
	protected function initialize(){}

	/**
	 * Build the theme structure.
	 *
	 * @param 	string	$view 	The view file to use
	 * @param 	array 	$data 	Data to pass to the structure
	 * @return 	Theme
	 */
	public function structure($view, array $data)
	{
		$this->layout = $this->view->make($this->locate->structure($view))
			->with((array) $data);

		return $this;
	}

	/**
	 * Build the theme template.
	 *
	 * @param 	string	$view 	The view file to use
	 * @param 	array 	$data 	Data to pass to the template
	 * @return 	Theme
	 * @throws	NoThemeStructureException
	 */
	public function template($view, array $data)
	{
		if ( ! is_object($this->layout)) throw new NoThemeStructureException;

		$this->layout->template = $this->view->make($this->locate->template($view))
			->with((array) $data);

		return $this;
	}

	/**
	 * Build the theme menu.
	 *
	 * @param 	Page	$page 	The current page
	 * @return 	Theme
	 * @throws	NoThemeTemplateException
	 */
	public function menu(Page $page)
	{
		if ( ! is_object($this->layout->template)) throw new NoThemeTemplateException;

		// Grab the menu item repo
		$menuItemRepo = app('MenuItemRepository');

		// Get the main menu items
		$menuMainItems = $menuItemRepo->getMainMenuItems($page->menu_id);

		// Get the sub menu items
		$menuSubItems = $menuItemRepo->getSubMenuItems($page->menu_id);

		// Filter out sub items to only what we would need for the sub menu
		$menuSubItemsFiltered = $menuSubItems->filter(function($m) use ($page)
		{
			//
		});

		$data = [
			'menuMainItems'	=> $menuMainItems,
			'menuSubItems'	=> $menuSubItems,
		];

		$this->layout->template->menuMain = $this->view->make($this->locate->partial('menu-main'))
			->with(['items' => $menuMainItems]);

		$this->layout->template->menuSub = $this->view->make($this->locate->partial('menu-sub'))
			->with(['items' => $menuSubItemsFiltered]);

		$this->layout->template->menuCombined = $this->view->make($this->locate->partial('menu-combined'))
			->with((array) $data);

		return $this;
	}

	/**
	 * Build the theme footer.
	 *
	 * @param 	array 	$data 	Data to pass to the footer
	 * @return 	Theme
	 * @throws	NoThemeTemplateException
	 */
	public function footer(array $data = [])
	{
		if ( ! is_object($this->layout->template)) throw new NoThemeTemplateException;

		$this->layout->template->footer = $this->view->make($this->locate->partial('footer'))
			->with((array) $data);

		return $this;
	}

	/**
	 * Build the page.
	 *
	 * @param 	string	$view 	The view file to use
	 * @param 	array 	$data 	Data to pass to the page
	 * @return 	Theme
	 * @throws	NoThemeTemplateException
	 */
	public function page($view, array $data)
	{
		if ( ! is_object($this->layout->template)) throw new NoThemeTemplateException;

		$this->layout->template->content = $this->view->make($this->locate->page($view))
			->with((array) $data);

		return $this;
	}

	/**
	 * Build the Javascript for the page.
	 *
	 * @param 	string	$view 	The view file to use
	 * @param 	array 	$data 	Data to pass to the Javascript view
	 * @return 	Theme
	 * @throws	NoThemeStructureException
	 */
	public function javascript($view, array $data)
	{
		if ( ! is_object($this->layout)) throw new NoThemeStructureException;

		$this->layout->javascript = $this->view->make($this->locate->javascript($view))
			->with((array) $data);

		return $this;
	}

	public function alerts(array $data)
	{
		if ( ! is_object($this->layout->template)) throw new NoThemeTemplateException;

		return $this;
	}

	public function ajax(array $data)
	{
		if ( ! is_object($this->layout->template)) throw new NoThemeTemplateException;

		return $this;
	}

	public function styles($view, array $data)
	{
		if ( ! is_object($this->layout)) throw new NoThemeStructureException;

		$this->layout->styles = $this->view->make($this->locate->style($view))
			->with((array) $data);

		return $this;
	}

	/**
	 * Return the View object with the complete template for rendering.
	 *
	 * @return 	View
	 */
	public function render()
	{
		return $this->layout;
	}

	/**
	 * Get the full name of the theme.
	 *
	 * @return	string
	 */
	public function getFullName()
	{
		return $this->name;
	}

	/**
	 * Get the author of the theme.
	 *
	 * @return	string
	 */
	public function getAuthor()
	{
		return $this->author;
	}

	/**
	 * Get the name of the theme folder or the full path to the theme.
	 *
	 * @param	bool	$raw	Get only the theme folder name?
	 * @return	string
	 */
	public function getLocation($raw = false)
	{
		if ($raw) return $this->location;

		return $this->app->themePath($this->location);
	}

	/**
	 * Get the preview image filename or an image tag to the preview image.
	 *
	 * @param	bool	$raw	Get only the theme preview filename?
	 * @param	array	$attr	Custom attributes to be added to the image tag
	 * @return	string
	 */
	public function getPreview($raw = false, array $attr = [])
	{
		if ($raw) return $this->preview;

		return $this->app['html']->image(
			$this->getLocation().'/'.$this->preview,
			null,
			$attr
		);
	}

	/**
	 * Get the theme credits as straight text or parsed Markdown.
	 *
	 * @param	bool	$raw	Get the unparsed credits?
	 * @return	string
	 */
	public function getCredits($raw = false)
	{
		if ($raw) return $this->credits;

		return $this->app['nova.markdown']->parse($this->credits);
	}

	/**
	 * Get the version of the theme.
	 *
	 * @return	string
	 */
	public function getVersion()
	{
		return $this->version;
	}

	public function setData($key, $data)
	{
		$this->data[$key] = $data;

		return $this;
	}

	public function setView($key, $file)
	{
		$this->views[$key] = $file;

		return $this;
	}

	/**
	 * If we ever echo out the theme, let's give the user the location to the
	 * theme instead of throwing some kind of error.
	 *
	 * @return	string
	 */
	public function __toString()
	{
		return $this->location;
	}

}