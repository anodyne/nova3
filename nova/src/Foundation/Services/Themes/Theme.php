<?php namespace Nova\Foundation\Services\Themes;

use Page;
use Exception;
use Spatie\Menu\Laravel\Link as LinkBuilder,
	Spatie\Menu\Laravel\Menu as MenuBuilder;
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

	protected $menuMainItems;
	protected $menuSubItems;

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
		if ( ! is_object($this->layout))
		{
			throw new NoThemeStructureException;
		}

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
	public function menu(Page $page = null)
	{
		if ( ! is_object($this->layout->template))
		{
			throw new NoThemeTemplateException;
		}

		if ($page === null)
		{
			return $this;
		}

		// Grab the menu item repo
		$menuItemRepo = app('MenuItemRepository');

		// Get the main menu items
		$this->menuMainItems = $menuItemRepo->getMainMenuItems($page->menu);

		// Get the sub menu items
		$this->menuSubItems = $menuItemRepo->getSubMenuItems($page->menu);

		// We want to use an array for the combined menu
		$menuSubItemsArr = $menuItemRepo->splitSubMenuItemsIntoArray($this->menuSubItems);

		// Filter out sub items to only what we would need for the sub menu
		$menuSubItemsFiltered = $this->menuSubItems->filter(function ($item) use ($page)
		{
			//return $item->parent->page_id == $page->id;
		});

		$data = [
			'menuMainItems'	=> $this->menuMainItems,
			'menuSubItems'	=> $menuSubItemsArr,
		];

		$menu = MenuBuilder::new()->addClass('nav navbar-nav');

		foreach ($this->menuMainItems as $mainMenuItem)
		{
			if (array_key_exists($mainMenuItem->id, $menuSubItemsArr))
			{
				$submenu = MenuBuilder::new()->addClass('dropdown-menu');
				$submenu->prepend(LinkBuilder::to('#', $mainMenuItem->title.' <span class="caret"></span>')
					->addParentClass('dropdown')
					->addClass('dropdown-toggle')
				);

				foreach ($menuSubItemsArr[$mainMenuItem->id] as $subMenuItem)
				{
					if ($subMenuItem->type == 'divider')
					{
						$submenu->add(LinkBuilder::to('#', '')->addParentClass('divider'));
					}
					else
					{
						switch ($subMenuItem->type)
						{
							case 'internal':
							case 'external':
								$submenu->add(LinkBuilder::to($subMenuItem->link, $subMenuItem->title));
							break;

							case 'page':
								$title = (empty($subMenuItem->title)) 
									? $subMenuItem->page->name
									: $subMenuItem->title;

								$submenu->add(LinkBuilder::route($subMenuItem->page->key, $title));
							break;

							case 'route':
								$submenu->add(LinkBuilder::route($subMenuItem->link, $subMenuItem->title));
							break;
						}
					}
				}

				$menu->add($submenu);
			}
			else
			{
				if ($mainMenuItem->type == 'divider')
				{
					$menu->add(LinkBuilder::to('#', '')->addParentClass('divider'));
				}
				else
				{
					switch ($mainMenuItem->type)
					{
						case 'internal':
						case 'external':
							$menu->add(LinkBuilder::to($mainMenuItem->link, $mainMenuItem->title));
						break;

						case 'page':
							$title = (empty($mainMenuItem->title)) 
								? $mainMenuItem->page->name
								: $mainMenuItem->title;

							$menu->add(LinkBuilder::route($mainMenuItem->page->key, $title));
						break;

						case 'route':
							$menu->add(LinkBuilder::route($mainMenuItem->link, $mainMenuItem->title));
						break;
					}
				}
			}
		}

		$this->layout->template->menuMain = $this->view->make($this->locate->partial('menu-main'))
			->with(['items' => $this->menuMainItems]);

		$this->layout->template->menuSub = $this->view->make($this->locate->partial('menu-sub'))
			->with(['items' => $menuSubItemsFiltered]);

		$this->layout->template->menuCombined = $this->view->make($this->locate->partial('menu-combined'))
			->with((array) $data);

		return $this;
	}

	public function menuNew(Page $page = null)
	{
		// Grab the menu item repo
		$menuItemRepo = app('MenuItemRepository');

		// Get the main menu items
		$this->menuMainItems = $menuItemRepo->getMainMenuItems($page->menu);

		// Get the sub menu items
		$this->menuSubItems = $menuItemRepo->getSubMenuItems($page->menu);

		// We want to use an array for the combined menu
		$menuSubItemsArr = $menuItemRepo->splitSubMenuItemsIntoArray($this->menuSubItems);

		// Filter out sub items to only what we would need for the sub menu
		$menuSubItemsFiltered = $this->menuSubItems->filter(function ($item) use ($page)
		{
			//return $item->parent->page_id == $page->id;
		});

		$data = [
			'menuMainItems'	=> $this->menuMainItems,
			'menuSubItems'	=> $menuSubItemsArr,
		];

		$menu = MenuBuilder::new()->addClass('nav navbar-nav');

		foreach ($this->menuMainItems as $mainMenuItem)
		{
			if (array_key_exists($mainMenuItem->id, $menuSubItemsArr))
			{
				// Build the header for the sub menu
				$header = LinkBuilder::to('#', $mainMenuItem->title.' <span class="caret"></span>');

				// Start building the submenu and prepend the first item
				$submenu = MenuBuilder::new()->addClass('dropdown-menu');
				$submenu->prepend($header->addClass('dropdown-toggle')->addParentClass('dropdown'));

				// Loop through the sub menu items and build the sub menu
				foreach ($menuSubItemsArr[$mainMenuItem->id] as $subMenuItem)
				{
					$submenu->add($this->buildMenuItem($subMenuItem));
				}

				// Now add the sub menu to the menu
				$menu->add($submenu);
			}
			else
			{
				$menu->add($this->buildMenuItem($mainMenuItem));
			}
		}

		return $menu;

		$this->layout->template->menuMain = $this->view->make($this->locate->partial('menu-main'))
			->with(['items' => $this->menuMainItems]);

		$this->layout->template->menuSub = $this->view->make($this->locate->partial('menu-sub'))
			->with(['items' => $menuSubItemsFiltered]);

		$this->layout->template->menuCombined = $this->view->make($this->locate->partial('menu-combined'))
			->with((array) $data);

		return $this;
	}

	public function adminMenu(Page $page = null)
	{
		return $this->menu($page);
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
		if ( ! is_object($this->layout->template))
		{
			throw new NoThemeTemplateException;
		}

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
		if ( ! is_object($this->layout->template))
		{
			throw new NoThemeTemplateException;
		}

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
		if ( ! is_object($this->layout))
		{
			throw new NoThemeStructureException;
		}

		$this->layout->javascript = $this->view->make($this->locate->javascript($view))
			->with((array) $data);

		return $this;
	}

	public function alerts(array $data)
	{
		if ( ! is_object($this->layout->template))
		{
			throw new NoThemeTemplateException;
		}

		return $this;
	}

	public function ajax(array $data)
	{
		if ( ! is_object($this->layout->template))
		{
			throw new NoThemeTemplateException;
		}

		return $this;
	}

	public function styles($view, array $data)
	{
		if ( ! is_object($this->layout))
		{
			throw new NoThemeStructureException;
		}

		$this->layout->styles = $this->view->make($this->locate->style($view))
			->with((array) $data);

		return $this;
	}

	public function panel()
	{
		if ( ! is_object($this->layout->template))
		{
			throw new NoThemeTemplateException;
		}

		$this->layout->template->panel = $this->view->make($this->locate->partial('panel'));

		return $this;
	}

	/**
	 * Return the View object with the complete template for rendering.
	 *
	 * @return 	View
	 */
	public function render()
	{
		return $this->layout->render();
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
		if ($raw)
		{
			return $this->location;
		}

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
		if ($raw)
		{
			return $this->preview;
		}

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
		if ($raw)
		{
			return $this->credits;
		}

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

	/**
	 * Get a specific icon out of the theme's icon map.
	 *
	 * @param	string
	 * @return	string
	 * @throws	Exception
	 */
	public function getIcon($icon)
	{
		return array_get($this->getIconMap(), $icon);
	}

	/**
	 * Get the theme icon map.
	 *
	 * @return	array
	 */
	public function getIconMap()
	{
		return [
			'edit' => 'edit',
			'close' => 'remove_circle_outline',
			'delete' => 'delete',
		];
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

	protected function buildMenuItem($item)
	{
		switch ($item->type)
		{
			case 'internal':
			case 'external':
				return LinkBuilder::to($item->link, $item->title);
			break;

			case 'page':
				$title = (empty($item->title)) 
					? $item->page->name
					: $item->title;

				return LinkBuilder::route($item->page->key, $title);
			break;

			case 'route':
				return LinkBuilder::route($item->link, $item->title);
			break;

			case 'divider':
				return LinkBuilder::to('#', '')->addParentClass('divider');
			break;
		}
	}

}