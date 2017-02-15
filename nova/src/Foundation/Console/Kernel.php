<?php namespace Nova\Foundation\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {

	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */
	protected $commands = [
		Commands\MakeExtensionCommand::class,
		Commands\MakeThemeCommand::class,
		\Nova\Setup\Commands\NovaRefreshCommand::class,
		\Nova\Setup\Commands\NovaUninstallCommand::class,
		\Nova\Setup\Commands\NovaInstallCommand::class,
	];

	/**
	 * Define the application's command schedule.
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
	 * @return void
	 */
	protected function schedule(Schedule $schedule)
	{
		//$schedule->command('inspire')->hourly();
	}

	/**
	 * Register the Closure based commands for the application.
	 *
	 * @return void
	 */
	protected function commands()
	{
		require nova_path('routes/console.php');
	}
}
