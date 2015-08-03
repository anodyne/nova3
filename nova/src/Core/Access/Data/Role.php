<?php namespace Nova\Core\Access\Data;

use RolePresenter;
use Zizaco\Entrust\EntrustRole;
use Laracasts\Presenter\PresentableTrait;

class Role extends EntrustRole {

	use PresentableTrait;

	protected $presenter = RolePresenter::class;

}
