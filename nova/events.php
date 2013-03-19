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

/**
 * User
 */
Event::listen("eloquent.creating: {$classes['User']}", "{$classes['UserHandler']}@beforeCreate");
Event::listen("eloquent.created: {$classes['User']}", "{$classes['UserHandler']}@afterCreate");
Event::listen("eloquent.updated: {$classes['User']}", "{$classes['UserHandler']}@afterUpdate");
Event::listen("eloquent.deleting: {$classes['User']}", "{$classes['UserHandler']}@beforeDelete");

/**
 * Comment Handlers
 */
//Event::listen("eloquent.created: {$classes['Comment']}", "{$classes['CommentHandler']}@onCreate");