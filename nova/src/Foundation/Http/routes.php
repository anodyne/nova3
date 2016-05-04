<?php

// Get all the pages out of the container
$pages = app('nova.pages');

if ($pages->count() > 0)
{
	// Allowed verbs
	$allowedVerbs = ['get', 'post', 'put', 'delete'];

	foreach ($pages as $page)
	{
		// Get the verb and format it
		$verb = strtolower($page->verb);

		// Make sure the page is using one of the allowed verbs
		if (in_array($verb, $allowedVerbs))
		{
			// Build the options
			$options['as'] = $page->key;
			$options['uses'] = ($page->resource) ?: $page->default_resource;

			call_user_func_array([$router, $verb], [$page->uri, $options]);
		}
	}
}
