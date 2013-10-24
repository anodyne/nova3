<?php

/**
 * Event handlers defined in the Nova core will run with a priority of 100. If
 * you want to override an event handler defined in the core, you'll need to
 * create a new array entry (following the format from the core events config
 * file) with a key of 0. If you want your event handler to run before the
 * event handler defined in the core, create a new array entry with a key
 * greater than 100. If you want your event handler to run after the event
 * handler defined in the core, create a new array entry with a key less than
 * 100.
 */

return [];