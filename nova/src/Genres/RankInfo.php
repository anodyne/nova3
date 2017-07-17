<?php namespace Nova\Genres;

use Eloquent;

class RankInfo extends Eloquent
{
	protected $table = 'ranks_info';
	protected $fillable = ['name', 'short_name'];
}
