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
 * Characters
 */
Event::listen("eloquent.created: {$classes['Character']}", "{$classes['CharacterHandler']}@afterCreate");

/**
 * Positions
 */
Event::listen("eloquent.created: {$classes['Position']}", "{$classes['PositionHandler']}@afterCreate");
Event::listen("eloquent.updated: {$classes['Position']}", "{$classes['PositionHandler']}@afterUpdate");
Event::listen("eloquent.deleting: {$classes['Position']}", "{$classes['PositionHandler']}@beforeDelete");

/**
 * Ranks
 */
Event::listen("eloquent.created: {$classes['Rank']}", "{$classes['RankHandler']}@afterCreate");
Event::listen("eloquent.updated: {$classes['Rank']}", "{$classes['RankHandler']}@afterUpdate");
Event::listen("eloquent.deleting: {$classes['Rank']}", "{$classes['RankHandler']}@beforeDelete");
Event::listen("eloquent.saving: {$classes['Rank']}", "{$classes['RankHandler']}@beforeSave");

/**
 * User
 */
Event::listen("eloquent.creating: {$classes['User']}", "{$classes['UserHandler']}@beforeCreate");
Event::listen("eloquent.created: {$classes['User']}", "{$classes['UserHandler']}@afterCreate");
Event::listen("eloquent.updated: {$classes['User']}", "{$classes['UserHandler']}@afterUpdate");
Event::listen("eloquent.deleting: {$classes['User']}", "{$classes['UserHandler']}@beforeDelete");