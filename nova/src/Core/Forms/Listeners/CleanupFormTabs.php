<?php namespace Nova\Core\Forms\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CleanupFormTabs implements ShouldQueue {

	use InteractsWithQueue;

	public function __construct(){}

	public function handle($event)
	{
		//
	}

}
