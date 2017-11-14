<?php namespace Nova\Setup\Migrations;

interface Migratable
{
	/**
	 * Handle any incoming data from other migration processes so that we can
	 * use that in our own migration if we need to.
	 */
	public function getData();

	/**
	 * Check to see if the migration process finished successfully.
	 */
	public function check();

	/**
	 * Run the migration process.
	 */
	public function migrate();

	/**
	 * Push data back to the migration manager so that other migrators can use
	 * the information we generated during the migration process in their own
	 * migration process.
	 */
	public function setData();

	/**
	 * Get the status back about whether the migration ran successfully or not.
	 */
	public function status();
}
