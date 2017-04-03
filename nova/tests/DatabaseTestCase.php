<?php namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;

abstract class DatabaseTestCase extends TestCase
{
	use DatabaseMigrations;
}
