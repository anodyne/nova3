<?php namespace Nova\Foundation\Themes;

use Auth, Form, HTML, Page, MenuItem;
use Spatie\Menu\Laravel\{Html as HtmlBuilder, Link as LinkBuilder, Menu as MenuBuilder};

class Theme implements ThemeIconsContract,
					   ThemeInfoContract,
					   ThemeMenusContract,
					   ThemeStructureContract {

	use ThemeIcons;

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

		$this->structure->template->adminMenuMain = partial('menu/menu-admin-main');
		$this->structure->template->adminMenuSub = partial('menu/menu-admin-sub');
		$this->structure->template->adminMenuCombined = partial('menu/menu-admin-combined');

		return $this;
	}

	public function buildAdminCombinedMenu()
	{
		// We want to use an array for the combined menu
		$menuSubItemsArr = app('MenuItemRepository')->splitSubMenuItemsIntoArray($this->menuSubItems);

		$menu = MenuBuilder::new()->addClass('navbar-nav mr-auto');

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
					->addClass('dropdown-toggle nav-link')
					->setAttribute('data-toggle', 'dropdown');

				// Start building the submenu and prepend the first item
				$submenu = MenuBuilder::new()
					->addClass('dropdown-menu')
					->addParentClass('dropdown nav-item');
				$submenu->prepend($header);

				// Loop through the sub menu items and build the sub menu
				foreach ($menuSubItemsArr[$mainMenuItem->id] as $subMenuItem)
				{
					$submenu->addIf(
						$subMenuItem->userHasAccess(user()),
						$this->buildMenuItem($subMenuItem, 'dropdown-item')
					);
				}

				// Now add the sub menu to the menu
				$menu->addIf(($submenu->count() > 0), $submenu);
			}
			else
			{
				$menu->addIf(
					$mainMenuItem->userHasAccess(user()),
					$this->buildMenuItem($mainMenuItem, 'nav-link')->addParentClass('nav-item')
				);
			}
		}

		MenuBuilder::macro('menuCombined', function () use ($menu)
		{
			return $menu;
		});

		return $menu;
	}

	public function buildAdminMainMenu()
	{
		$menu = MenuBuilder::new()->addClass('navbar navbar-light bg-faded');

		foreach ($this->menuMainItems as $mainMenuItem)
		{
			$menu->addIf(
				$mainMenuItem->userHasAccess(user()),
				$this->buildMenuItem($mainMenuItem)
			);
		}

		MenuBuilder::macro('menuMain', function () use ($menu)
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
			$menu->addIf(
				$subMenuItem->userHasAccess(user()),
				$this->buildMenuItem($subMenuItem, 'list-group-item')
			);
		}

		MenuBuilder::macro('menuSub', function () use ($menu) {
			return $menu;
		});

		return $menu;
	}

	public function buildMenuItem(MenuItem $item, $class = false)
	{
		$title = $item->present()->title;

		switch ($item->type) {
			case 'internal':
			case 'external':
				return LinkBuilder::to($item->link, $title)->addClass($class);
			break;

			case 'page':
				$page = app('nova.pages')->where('id', $item->page_id)->first();

				return LinkBuilder::toRoute($page->key, $title)->addClass($class);
			break;

			case 'route':
				return LinkBuilder::toRoute($item->link, $title)->addClass($class);
			break;

			case 'divider':
				return HtmlBuilder::raw('')->addParentClass('dropdown-divider');
			break;
		}
	}

	public function buildPublicCombinedMenu()
	{
		// We want to use an array for the combined menu
		$menuSubItemsArr = app('MenuItemRepository')
			->splitSubMenuItemsIntoArray($this->menuSubItems);

		$menu = MenuBuilder::new()->addClass('navbar-nav mr-auto');

		foreach ($this->menuMainItems as $mainMenuItem) {
			if (array_key_exists($mainMenuItem->id, $menuSubItemsArr)) {
				// Build the text for the header link
				$headerText = sprintf('%s %s', 
					$mainMenuItem->present()->title,
					HtmlBuilder::raw('<span class="caret"></span>')->render()
				);

				// Build the header for the sub menu
				$header = LinkBuilder::to('#', $headerText)
					->addClass('dropdown-toggle nav-link')
					->setAttribute('data-toggle', 'dropdown');

				// Start building the submenu and prepend the first item
				$submenu = MenuBuilder::new()
					->addClass('dropdown-menu')
					->addParentClass('dropdown nav-item');
				$submenu->prepend($header);

				// Loop through the sub menu items and build the sub menu
				foreach ($menuSubItemsArr[$mainMenuItem->id] as $subMenuItem) {
					$submenu->addIf(
						$subMenuItem->userHasAccess(user()),
						$this->buildMenuItem($subMenuItem, 'dropdown-item')
					);
				}

				// Now add the sub menu to the menu
				$menu->addIf(($submenu->count() > 0), $submenu);
			} else {
				$menu->addIf(
					$mainMenuItem->userHasAccess(user()),
					$this->buildMenuItem($mainMenuItem, 'nav-link')->addParentClass('nav-item')
				);
			}
		}

		MenuBuilder::macro('menuCombined', function () use ($menu) {
			return $menu;
		});

		return $menu;
	}

	public function buildPublicMainMenu()
	{
		$menu = MenuBuilder::new()->addClass('nav navbar-nav');

		foreach ($this->menuMainItems as $mainMenuItem) {
			$menu->addIf(
				$mainMenuItem->userHasAccess(user()),
				$this->buildMenuItem($mainMenuItem)
			);
		}

		MenuBuilder::macro('menuMain', function () use ($menu) {
			return $menu;
		});

		return $menu;
	}

	public function buildPublicSubMenu(Page $page)
	{
		// Start by filtering to only the menu items for the page's menu
		$menuItems = $this->menuSubItems->where('menu_id', $page->menu_id);

		// Next filter out only the items we need based on the page itself
		$menuSubItemsFiltered = $menuItems->filter(function ($item) use ($page) {
			if ($page->menuItems->count() > 0 and $page->parent_id == 0) {
				return $item->parent_id == $page->menuItems->first()->id;
			}
		});

		/*// Filter out sub items to only what we would need for the sub menu
		$menuSubItemsFiltered = $this->menuSubItems->filter(function ($item) use ($page)
		{
			if ((int) $page->parent_id === 0)
			{
				return $item->menu_id == $page->menu_id and $item->parent_id == $page->menuItems->first()->id;
			}

			d($page->id, $page->name);
			return $item->parent_id === 20;
			if ((int) $page->parent_id === 0)
			{
				return (int) $item->parent_id === (int) $page->id;
			}

			//d($item->parent_id, $page->id);
			//return $item->parent_id === $page->id;
			//return $item->parent->page_id == $page->id;
		});*/

		//dd($menuSubItemsFiltered);

		$menu = MenuBuilder::new()->addClass('list-group');

		foreach ($menuSubItemsFiltered as $subMenuItem) {
			$menu->addIf(
				$subMenuItem->userHasAccess(user()),
				$this->buildMenuItem($subMenuItem)->addParentClass('list-group-item')
			);
		}

		MenuBuilder::macro('menuSub', function () use ($menu) {
			return $menu;
		});

		return $menu;
	}

	public function buildUserMenu()
	{
		$menu = MenuBuilder::new()->addClass('nav navbar-nav pull-md-right');

		if (Auth::check()) {
			$indicatorClass = (user()->unreadNotifications->count() == 0)
				? 'nav-link notification-indicator unread'
				: 'nav-link notification-indicator';

			$menu->add(LinkBuilder::toUrl('#', $this->renderIcon('bell').'&nbsp;')
				->setAttributes(['data-toggle' => 'modal', 'data-target' => '#notification-panel'])
				->addClass($indicatorClass)
				->addParentClass('nav-item'));

			// Build the text for the header link
			$headerText = sprintf('%s %s', 
				user()->present()->name,
				HtmlBuilder::raw('<span class="caret"></span>')->render()
			);

			// Build the header for the sub menu
			$header = LinkBuilder::to('#', $headerText)
				->addClass('dropdown-toggle nav-link')
				->setAttributes(['data-toggle' => 'dropdown', 'role' => 'button']);

			// Build the submenu
			$submenu = MenuBuilder::new()->addClass('dropdown-menu dropdown-menu-right')->addParentClass('nav-item');
			$submenu->add(LinkBuilder::toRoute('admin.users.account', "My Account")->addClass('dropdown-item'));
			$submenu->add(LinkBuilder::toRoute('admin.users.preferences', "My Preferences")->addClass('dropdown-item'));
			$submenu->html('', ['role' => 'separator', 'class' => 'dropdown-divider']);
			$submenu->add(LinkBuilder::toRoute('signout', _m('sign-out'))->addClass('dropdown-item'));

			// Attach the submenu to the user menu
			$menu->submenu($header, $submenu);
		} else {
			$menu->add(
				LinkBuilder::toRoute('signin', _m('sign-in'))
					->addClass('nav-link')
					->addParentClass('nav-item')
			);
		}

		MenuBuilder::macro('menuUser', function () use ($menu) {
			return $menu;
		});
	}

	public function publicMenu(Page $page = null)
	{
		if ($page === null) {
			return $this;
		}

		if ( ! is_object($this->structure->template)) {
			throw new Exceptions\NoThemeTemplateException;
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

		$this->structure->template->publicMenuMain = partial('menu/menu-public-main');
		$this->structure->template->publicMenuSub = partial('menu/menu-public-sub');
		$this->structure->template->publicMenuCombined = partial('menu/menu-public-combined');

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
