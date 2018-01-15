<?php namespace Nova\Foundation\Console;

use Illuminate\Console\Scheduling\Schedule;
use Nova\Setup\Console\Commands;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
	protected $commands = [
		Commands\UpdateNova::class,
		Commands\InstallNova::class,
		Commands\RefreshNova::class,
		Commands\UninstallNova::class,
		\Nova\Extensions\Console\Commands\MakeExtension::class,
	];

	protected function schedule(Schedule $schedule)
	{
		$schedule->command('nova:refresh')
				 ->dailyAt('04:30');
	}

	protected function commands()
	{
		require base_path('nova/routes/console.php');
	}
}
