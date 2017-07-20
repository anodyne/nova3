<?php namespace Nova\Settings;

use Eloquent;

class Settings extends Eloquent
{
	protected $table = 'settings';
	protected $fillable = ['key', 'value'];
}