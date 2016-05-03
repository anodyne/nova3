<?php namespace Nova\Foundation\Themes;

use Page, MenuItem;

interface ThemeMenusContract {

	public function adminMenu(Page $page = null);
	public function buildAdminCombinedMenu();
	public function buildAdminMainMenu();
	public function buildAdminSubMenu(Page $page);
	public function buildMenuItem(MenuItem $item, $class = false);
	public function buildPublicCombinedMenu();
	public function buildPublicMainMenu();
	public function buildPublicSubMenu(Page $page);
	public function buildUserMenu();
	public function publicMenu(Page $page = null);

}
