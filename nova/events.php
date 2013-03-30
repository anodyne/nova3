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
$classes = Config::get('app.aliases');