# The Cache

To improve performance, Nova 3 caches as much content as possible.

Here are the items that Nova caches as well as the reasons for being cached and the key you can use to call the items directly out of the cache.

* Nova Install Status
	* Cache key: `nova.installed`
	* The check of whether Nova is installed happens on every request. In order to facilitate a faster check, the status is cached.
* Installed Modules
	* Cache key: `nova.modules`
	* Since all modules are checked during routing and for the loading of route files, the locations of all activated modules are stored in the cache.
* Settings
	* Cache key: `nova.settings`
	* All settings are stored in the cache for quick access since the entire settings table is available on each request.
	* `Settings::getItems()` will check the cache first before querying the database.
* Site Content
	* Cache key: `nova.content.{type}.{section}`
		* Type can be "header", "title", "message" or "other"
		* Section is either the first URI segment in non-admin pages or the second URI segment in admin pages.
	* All page headers, page titles and page messages are stored in the cache for quick access since they could be called from any request.