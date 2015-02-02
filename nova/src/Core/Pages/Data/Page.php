<?php namespace Nova\Core\Pages\Data;

use Model;

class Page extends Model {

	protected $table = 'pages';

	protected $fillable = ['collection_id', 'type', 'name', 'uri', 'resource',
		'default_resource', 'protected', 'description'];

	protected $casts = [
		'collection_id'	=> 'integer',
		'protected'		=> 'boolean',
	];

	protected $dates = ['created_at', 'updated_at'];
	
}
