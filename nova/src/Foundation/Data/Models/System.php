<?php namespace Nova\Foundation\Data\Models;

use Eloquent;

class System extends Eloquent {

	protected $table = 'system_info';

	protected $fillable = ['uid', 'version_major', 'version_minor',
		'version_patch', 'version_ignore'];

	protected $dates = ['created_at', 'updated_at'];

}