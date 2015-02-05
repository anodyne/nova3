<?php namespace Nova\Core\Pages\Data;

use Model;
use Laracasts\Presenter\PresentableTrait;

class Page extends Model {

	use PresentableTrait;

	protected $table = 'pages';

	protected $fillable = ['collection_id', 'verb', 'name', 'uri', 'resource',
		'default_resource', 'protected', 'description'];

	protected $casts = [
		'collection_id'	=> 'integer',
		'protected'		=> 'boolean',
	];

	protected $dates = ['created_at', 'updated_at'];

	protected $presenter = 'Nova\Core\Pages\Data\Presenters\PagePresenter';
	
}
