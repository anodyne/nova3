<?php namespace Nova\Foundation\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
	protected $commands = [
		//
	];

	protected function schedule(Schedule $schedule)
	{
		$schedule->command('nova:refresh-demo')
				 ->dailyAt('04:30');
	}

	protected function commands()
	{
		require base_path('nova/routes/console.php');
	}
}
