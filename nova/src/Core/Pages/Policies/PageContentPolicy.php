<?php namespace Nova\Core\Pages\Policies;

use Nova\Foundation\Policy;

class PageContentPolicy extends Policy {

	protected $createKey = 'page.create';
	protected $editKey = 'page.edit';
	protected $removeKey = 'page.remove';
}
