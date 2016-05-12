<?php namespace Nova\Foundation\Themes;

use Auth, Form, HTML, Page, MenuItem;
use Spatie\Menu\Laravel\{Html as HtmlBuilder, Link as LinkBuilder, Menu as MenuBuilder};

class Theme implements ThemeIconsContract,
					   ThemeInfoContract,
					   ThemeMenusContract,
					   ThemeStructureContract {

	public $name;
	public $author;
	public $credits;
	public $version;
	public $location;
	public $previewImage;

	public $menuMainItems;
	public $menuSubItems;

	public $structure;

	public function __construct(string $themeName)
	{
		// Grab the JSON file and parse it
		$theme = json_decode(file_get_contents(app()->themePath($themeName).'/theme.json'));

		// Assign the properties
		$this->name 		= $theme->name;
		$this->author		= $theme->author;
		$this->credits 		= $theme->credits;
		$this->version 		= $theme->version;
		$this->location 	= $theme->location;
		$this->previewImage	= $theme->preview;

		// Allow for some initializing
		$this->initialize();
	}

	/**
	 * ThemeIcons Contract Implementation
	 */
	public function buildIconList()
	{
		$icons = [];

		foreach ($this->getIconMap() as $key => $value)
		{
			$icons[] = [
				'key' => $key,
				'value' => $value,
				'preview' => $this->renderIcon($key),
			];
		}

		return $icons;
	}

	public function getIcon(string $icon)
	{
		return array_get($this->getIconMap(), $icon);
	}

	public function getIconMap(): array
	{
		return [
			'add'			=> 'plus',
			'announcement'	=> 'bullhorn',
			'archive'		=> 'archive',
			'arrow-back'	=> 'arrow-left',
			'arrow-down'	=> 'arrow-down',
			'arrow-forward'	=> 'arrow-right',
			'arrow-up'		=> 'arrow-up',
			'ban'			=> 'ban',
			'bolt'			=> 'bolt',
			'book'			=> 'book',
			'bookmark'		=> 'bookmark',
			'briefcase'		=> 'briefcase',
			'brush'			=> 'paint-brush',
			'calendar'		=> 'calendar-o',
			'chart-area'	=> 'area-chart',
			'chart-bar'		=> 'bar-chart',
			'chart-line'	=> 'line-chart',
			'chart-pie'		=> 'pie-chart',
			'check'			=> 'check',
			'clock'			=> 'clock-o',
			'close'			=> 'times',
			'cloud'			=> 'cloud',
			'cloud-download'=> 'cloud-download',
			'cloud-upload'	=> 'cloud-upload',
			'code'			=> 'code',
			'comment'		=> 'comment',
			'comments'		=> 'comments',
			'copy'			=> 'clone',
			'cut'			=> 'scissors',
			'dashboard'		=> 'tachometer',
			'delete'		=> 'trash',
			'desktop'		=> 'desktop',
			'directions'	=> 'map-signs',
			'download'		=> 'download',
			'edit'			=> 'pencil',
			'email'			=> 'envelope',
			'file'			=> 'file-o',
			'fire'			=> 'fire',
			'flag'			=> 'flag',
			'folder'		=> 'folder',
			'folder-open'	=> 'folder-open',
			'forward'		=> 'share',
			'frown'			=> 'frown-o',
			'gift'			=> 'gift',
			'heart'			=> 'heart',
			'heart-empty'	=> 'heart-o',
			'history'		=> 'history',
			'home'			=> 'home',
			'image'			=> 'image',
			'inbox'			=> 'inbox',
			'info'			=> 'info-circle',
			'key'			=> 'key',
			'laptop'		=> 'laptop',
			'leaf'			=> 'leaf',
			'light'			=> 'lightbulb-o',
			'link'			=> 'link',
			'list'			=> 'list-ul',
			'location'		=> 'map-marker',
			'lock'			=> 'lock',
			'mobile'		=> 'mobile',
			'more'			=> 'ellipsis-h',
			'not-visible'	=> 'eye-slash',
			'notifications'	=> 'bell',
			'paste'			=> 'clipboard',
			'question'		=> 'question',
			'refresh'		=> 'refresh',
			'reply'			=> 'reply',
			'reply-all'		=> 'reply-all',
			'search'		=> 'search',
			'send'			=> 'paper-plane',
			'settings'		=> 'cog',
			'share'			=> 'share-alt',
			'shield'		=> 'shield',
			'sign-in'		=> 'sign-in',
			'sign-out'		=> 'sign-out',
			'smile'			=> 'smile-o',
			'star'			=> 'star',
			'star-empty'	=> 'star-o',
			'tablet'		=> 'tablet',
			'tag'			=> 'tag',
			'tasks'			=> 'tasks',
			'thumbs-down'	=> 'thumbs-down',
			'thumbs-up'		=> 'thumbs-up',
			'ticket'		=> 'ticket',
			'trophy'		=> 'trophy',
			'unlock'		=> 'unlock',
			'upload'		=> 'upload',
			'user'			=> 'user',
			'users'			=> 'users',
			'visible'		=> 'eye',
			'warning'		=> 'exclamation-triangle',
			'wizard'		=> 'magic',
			'wrench'		=> 'wrench',
		];
	}

	public function iconTemplate(): string
	{
		return '<i class="fa fa-%icon% %classes%"></i>';
	}

	public function renderIcon(string $icon, $additionalClasses = false)
	{
		$output = str_replace('%classes%', $additionalClasses, $this->iconTemplate());
		$output = str_replace('%icon%', $this->getIcon($icon), $output);

		return $output;
	}

	/**
	 * ThemeInfo Contract Implementation
	 */
	public function getPreviewImage(array $attributes = [])
	{
		$location = sprintf("%s/%s", $this->themePath(), $this->previewImage);

		return HTML::image($location, null, $attributes);
	}

	public function getThemePath(): string
	{
		return app()->themePath($this->location);
	}

	public function initialize(){}

	/**
	 * ThemeMenus Contract Implementation
	 */
	public function adminMenu(Page $page = null)
	{
		if ( ! is_object($this->structure->template))
		{
			throw new Exceptions\NoThemeTemplateException;
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

		// Build the menus
		$this->buildAdminMainMenu();
		$this->buildAdminSubMenu($page);
		$this->buildAdminCombinedMenu();
		$this->buildUserMenu();

		$this->structure->template->menuTop = partial('menu-top');
		$this->structure->template->menuSide = partial('menu-side');

		return $this;
	}

	public function buildAdminCombinedMenu()
	{
		// We want to use an array for the combined menu
		$menuSubItemsArr = app('MenuItemRepository')->splitSubMenuItemsIntoArray($this->menuSubItems);

		$menu = MenuBuilder::new()->addClass('nav navbar-nav');

		foreach ($this->menuMainItems as $mainMenuItem)
		{
			if (array_key_exists($mainMenuItem->id, $menuSubItemsArr))
			{
				// Build the text for the header link
				$headerText = sprintf('%s %s', 
					$mainMenuItem->title,
					HtmlBuilder::raw('<span class="caret"></span>')->render()
				);

				// Build the header for the sub menu
				$header = LinkBuilder::to('#', $headerText)
					->addClass('dropdown-toggle')
					//->addParentClass('dropdown')
					->setAttribute('data-toggle', 'dropdown');

				// Start building the submenu and prepend the first item
				$submenu = MenuBuilder::new()->addClass('dropdown-menu');
				$submenu->prepend($header);

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

		MenuBuilder::macro('combinedMenu', function () use ($menu)
		{
			return $menu;
		});

		return $menu;
	}

	public function buildAdminMainMenu()
	{
		$menu = MenuBuilder::new()->addClass('nav navbar-nav');

		foreach ($this->menuMainItems as $mainMenuItem)
		{
			$menu->add($this->buildMenuItem($mainMenuItem));
		}

		MenuBuilder::macro('mainMenu', function () use ($menu)
		{
			return $menu;
		});

		return $menu;
	}

	public function buildAdminSubMenu(Page $page)
	{
		// Filter out sub items to only what we would need for the sub menu
		$menuSubItemsFiltered = $this->menuSubItems->filter(function ($item) use ($page)
		{
			return $item->parent_id === 9;
			return $item->parent->page_id == $page->id;
		});

		$menu = MenuBuilder::new()->addClass('list-group');

		foreach ($menuSubItemsFiltered as $subMenuItem)
		{
			$menu->add($this->buildMenuItem($subMenuItem, 'list-group-item'));
		}

		MenuBuilder::macro('subMenu', function () use ($menu)
		{
			return $menu;
		});

		return $menu;
	}

	public function buildMenuItem(MenuItem $item, $class = false)
	{
		$title = $item->present()->title;

		switch ($item->type)
		{
			case 'internal':
			case 'external':
				return LinkBuilder::to($item->link, $title)->addClass($class);
			break;

			case 'page':
				return LinkBuilder::route($item->page->key, $title)->addClass($class);
			break;

			case 'route':
				return LinkBuilder::route($item->link, $title)->addClass($class);
			break;

			case 'divider':
				return HtmlBuilder::raw('')->addParentClass('divider');
			break;
		}
	}

	public function buildPublicCombinedMenu()
	{
		// We want to use an array for the combined menu
		$menuSubItemsArr = app('MenuItemRepository')->splitSubMenuItemsIntoArray($this->menuSubItems);

		$menu = MenuBuilder::new()->addClass('nav navbar-nav');

		foreach ($this->menuMainItems as $mainMenuItem)
		{
			if (array_key_exists($mainMenuItem->id, $menuSubItemsArr))
			{
				// Build the text for the header link
				$headerText = sprintf('%s %s', 
					$mainMenuItem->present()->title,
					HtmlBuilder::raw('<span class="caret"></span>')->render()
				);

				// Build the header for the sub menu
				$header = LinkBuilder::to('#', $headerText)
					->addClass('dropdown-toggle')
					//->addParentClass('dropdown')
					->setAttribute('data-toggle', 'dropdown');

				// Start building the submenu and prepend the first item
				$submenu = MenuBuilder::new()->addClass('dropdown-menu');
				$submenu->prepend($header);

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

		MenuBuilder::macro('combinedMenu', function () use ($menu)
		{
			return $menu;
		});

		return $menu;
	}

	public function buildPublicMainMenu()
	{
		$menu = MenuBuilder::new()->addClass('nav navbar-nav');

		foreach ($this->menuMainItems as $mainMenuItem)
		{
			$menu->add($this->buildMenuItem($mainMenuItem));
		}

		MenuBuilder::macro('mainMenu', function () use ($menu)
		{
			return $menu;
		});

		return $menu;
	}

	public function buildPublicSubMenu(Page $page)
	{
		// Filter out sub items to only what we would need for the sub menu
		$menuSubItemsFiltered = $this->menuSubItems->filter(function ($item) use ($page)
		{
			return $item->parent_id === 9;
			return $item->parent->page_id == $page->id;
		});

		$menu = MenuBuilder::new()->addClass('list-group');

		foreach ($menuSubItemsFiltered as $subMenuItem)
		{
			$menu->add($this->buildMenuItem($subMenuItem, 'list-group-item'));
		}

		MenuBuilder::macro('subMenu', function () use ($menu)
		{
			return $menu;
		});

		return $menu;
	}

	public function buildUserMenu()
	{
		$menu = MenuBuilder::new()->addClass('nav navbar-nav navbar-right');

		if (Auth::check())
		{
			$menu->add(LinkBuilder::url('#', $this->renderIcon('notifications')));

			// Build the text for the header link
			$headerText = sprintf('%s %s', 
				Auth::user()->present()->name,
				HtmlBuilder::raw('<span class="caret"></span>')->render()
			);

			// Build the header for the sub menu
			$header = LinkBuilder::to('#', $headerText)
				->addClass('dropdown-toggle')
				//->addParentClass('dropdown')
				->setAttribute('data-toggle', 'dropdown');

			$submenu = MenuBuilder::new()->addClass('dropdown-menu');
			$submenu->prepend($header);

			$submenu->add(LinkBuilder::url('#', "My Account"));
			$submenu->add(LinkBuilder::route('admin.users.preferences', "My Preferences"));
			$submenu->add(HtmlBuilder::raw('')->addParentClass('divider'));
			$submenu->add(LinkBuilder::route('logout', "Log Out"));

			$menu->add($submenu);
		}
		else
		{
			$menu->add(LinkBuilder::route('login', "Log In"));
		}

		MenuBuilder::macro('userMenu', function () use ($menu)
		{
			return $menu;
		});
	}

	public function publicMenu(Page $page = null)
	{
		if ( ! is_object($this->structure->template))
		{
			throw new Exceptions\NoThemeTemplateException;
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

		// Build the menus
		$this->buildPublicMainMenu();
		$this->buildPublicSubMenu($page);
		$this->buildPublicCombinedMenu();
		$this->buildUserMenu();

		$this->structure->template->menuTop = partial('menu-top');
		$this->structure->template->menuSide = partial('menu-side');

		return $this;
	}

	/**
	 * ThemeStructure Contract Implementation
	 */
	public function structure($view, array $data)
	{
		$this->structure = view(locate()->structure($view), (array) $data);

		return $this;
	}

	public function template($view, array $data)
	{
		if ( ! is_object($this->structure))
		{
			throw new Exceptions\NoThemeStructureException;
		}

		$this->structure->template = view(locate()->template($view), (array) $data);

		return $this;
	}

	public function page($view, array $data)
	{
		if ( ! is_object($this->structure->template))
		{
			throw new Exceptions\NoThemeTemplateException;
		}

		$this->structure->template->content = view(locate()->page($view), (array) $data);

		return $this;
	}

	public function scripts(array $scripts)
	{
		if ( ! is_object($this->structure))
		{
			throw new Exceptions\NoThemeStructureException;
		}

		$output = "";

		foreach ($scripts as $script)
		{
			$path = sprintf("%s.js", locate()->javascript($script));

			$output.= HTML::script($path)."\r\n";
		}

		$this->structure->scripts = $output;

		return $this;
	}

	public function styles(array $styles)
	{
		if ( ! is_object($this->structure))
		{
			throw new Exceptions\NoThemeStructureException;
		}

		$output = "";

		foreach ($styles as $style)
		{
			$path = sprintf("%s.css", locate()->style($style));

			$output.= HTML::style($path)."\r\n";
		}

		$this->structure->styles = $output;

		return $this;
	}

	public function footer(array $data = [])
	{
		if ( ! is_object($this->structure->template))
		{
			throw new Exceptions\NoThemeTemplateException;
		}

		$this->structure->template->footer = partial('footer', (array) $data);

		return $this;
	}

	public function panel()
	{
		if ( ! is_object($this->structure->template))
		{
			throw new Exceptions\NoThemeTemplateException;
		}

		$this->structure->template->panel = partial('panel');

		return $this;
	}

	public function render()
	{
		return $this->structure->render();
	}

}
