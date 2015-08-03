<?php namespace Nova\Core\Access\Data;

use PermissionPresenter;
use Zizaco\Entrust\EntrustPermission;
use Laracasts\Presenter\PresentableTrait;

class Permission extends EntrustPermission {

	use PresentableTrait;

	protected $fillable = ['name', 'display_name', 'description'];

	protected $casts = [
		'protected'	=> 'boolean',
	];

	protected $presenter = PermissionPresenter::class;

}
