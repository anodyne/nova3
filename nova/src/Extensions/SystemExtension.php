<?php namespace Nova\Extensions;

use Eloquent;
use Nova\Foundation\Data\Reorderable;

class SystemExtension extends Eloquent
{
	use Reorderable;

	protected $table = 'system_extensions';
	protected $fillable = [
		'title', 'description', 'credits', 'author', 'version', 'link',
		'vendor', 'name', 'status', 'order',
	];
}
