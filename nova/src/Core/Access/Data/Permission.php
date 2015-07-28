<?php namespace Nova\Core\Access\Data;

use Zizaco\Entrust\EntrustPermission;
use Laracasts\Presenter\PresentableTrait;

class Permission extends EntrustPermission {

	use PresentableTrait;

	protected $presenter = 'Nova\Core\Access\Data\Presenters\PermissionPresenter';

}
