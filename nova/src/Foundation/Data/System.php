<?php namespace Nova\Foundation\Data;

use Model;

class System extends Model {

	protected $table = 'system_info';

	protected $fillable = ['uid', 'version_major', 'version_minor',
		'version_patch', 'version_ignore'];

	protected $dates = ['created_at', 'updated_at'];

}