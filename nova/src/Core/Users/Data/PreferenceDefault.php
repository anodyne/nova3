<?php namespace Nova\Core\Users\Data;

use Model;

class PreferenceDefault extends Model {

	public $timestamps = false;

	protected $table = 'users_preferences_defaults';

	protected $fillable = ['key', 'default'];

}
