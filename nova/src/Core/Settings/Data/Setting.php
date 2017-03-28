<?php namespace Nova\Core\Settings\Data;

use Model;

class Setting extends Model
{
	protected $table = 'settings';

	protected $fillable = ['key', 'value', 'label'];

	protected $casts = [
		'protected' => 'boolean',
	];

	protected $dates = ['created_at', 'updated_at'];
}
