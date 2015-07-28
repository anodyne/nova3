<?php namespace Nova\Core\Access\Data;

use Zizaco\Entrust\EntrustRole;
use Laracasts\Presenter\PresentableTrait;

class Role extends EntrustRole {

	use PresentableTrait;

	protected $presenter = 'Nova\Core\Access\Data\Presenters\RolePresenter';

}
