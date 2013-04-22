<?php
/**
 * Event Handlers.
 *
 * Nova makes extensive use of Laravel's events to take actions
 * at specific times during execution. Most of these handlers are
 * related to database-specific actions and are listed here.
 *
 * If you want to alter an event handler, you will need to override
 * the existing file and change the alias in the app.php config file.
 */

// Get all the aliases
$aliases = Config::get('app.aliases');

// Get the event config file
$events = Config::get('events');

// Loop through the events
foreach ($events as $event => $handlers)
{
	// Make sure the handlers is an array
	$handlers = ( ! is_array($handlers)) ? array($handlers) : $handlers;

	// Loop through the handler classes and set the listeners
	foreach ($handlers as $h)
	{
		// Set the final class to use
		$finalHandler = (array_key_exists($h, $aliases)) ? $aliases[$h] : $h;

		// Listen to the event
		Event::listen($event, $finalHandler);
	}
}