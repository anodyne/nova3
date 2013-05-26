## Latest `laravel/laravel` Commit

* 05/26/2013
* 15bd1bfa635f07a719167de97664ba4f9e7ec8b4

## Composer Packages

* dflydev/markdown
	* Markdown parsing
* cartalyst/sentry
	* Authentication and authorization
* cartalyst/api
	* API helpers and request/response layer
* ikimea/browser
	* Browser detection
* raveren/kint
	* Debugging output helpers
* baum/baum
	* Nested set model

## Nova 3 Work

* Migrations
	* Status: COMPLETE
	* How do we handle migrations in L4?
		* Can be handled with `Artisan::call('migrate')`.
	* How do we run migrations from a location other than `app`?
		* If the migrations are in a composer package, they can be run with something like `--package=foo/bar` but how do we run them when they aren't in a composer package?
		* `Artisan::call('migrate --path=app/foo/migrations')`
	* Do we do the data dump in each migration or seed the database?
		* We can install data with seeding through `Artisan::call('db:seed')`. This could be a little trickier though because of how we're going to use migrations. Might be better in the long run to keep the data right in the migrations and use seeding for dev data only.
	* Does the Artisan binary need to exist in order to run that command?
	* There's been talk of other ways to run migrations without going through the Artisan command. Keep an eye out for what those may be.
* Exceptions
	* Status: IN PROGRESS
	* Need to set up error handlers for different types of exceptions. This type of thing would allow specific error pages for specific types of exceptions and even allows cascading error handlers too.
		* 404 (Completed)
		* 500
		* Database error

## Changes to Laravel 4

* Routing
	* Status: IN PROGRESS
	* The new router checks the request path and tries to find a controller/action that matches that path. If nothing is found, it searches through the explicitly created routes. If it isn't found there, it throws an exception.
	* If the request path is empty, the router falls back to a request path of `main/index`.
	* TODO: Would love to figure out a way to have the core modules use explicit routing and everything else use dynamic routing. This would improve load times, but the trick is how do you then override a core page? You'd have to explicitly create a new route. I'm not opposed to it, but it is more work for developers.
	* TODO: Would like to have RESTful controllers that can be used or not, it's up to the developer.
		* getAction
		* postAction
		* putAction
		* deleteAction
* Controllers
	* Status: TESTING
	* Controllers need better before/after actions. Currently the only thing there is are filters, but those are too global to handle the granular control needed when loading up or shutting down specific controllers.
		* App filters can be run for everything, but there's also more granular route filters that can be used. In our case, we can build several route filters and then call them in the base controller constructor. This should suffice as they cascade like the before/after methods do in Fuel.
* Modules
	* Status: TESTING
	* The idea here would be to generate a specific namespace people could drop their modules into, say `Module`. This would need to tie in to the routing changes as well.
	* We need to cache the list of _active_ modules so that it can be used anywhere. If we pulled everything, we could accidentally be pulling something that's inactive or the GM doesn't want out there for a specific reason.
* Vendor
	* Status: COMPLETE
	* The vendor directory is stored in the `nova` directory.
	* Constants have been created for the base path, app path, nova path and vendor path.
* Config
	* Status: COMPLETE
	* Config files are pulled from `app`, `nova/wiki`, `nova/forum` and `nova/core`. They're pulled in in such an order that the app will override what's set in the core. This also take the environment folders into account as well. The only place we should have environment config folders is `app`.
	* Module config files cannot be used to change settings in `app`. Users should be aware that something is changing a config and allowing them in modules would make those waters murkier.
* Models
	* Status: TESTING
	* Callbacks/observers to make life a little easier with handling dependent actions triggered off an event.
		* The `insert()` and `update()` methods are in the QueryBuilder, not the Eloquent model, so we either have to do some pretty elaborate overriding or we have to copy the entire `save()` method from the model and insert the observers that way. If we go that route, we have to keep an eye on that file moving forward to make sure there are no changes to it that could impact the model.
		* Probably can use events instead of re-inventing the wheel here, but need a few things first:
			* Need to see examples of how to use events with models. When I tried listening to `eloquent.created` it wouldn't fire properly.
			* Need to figure out the best way of handling them so that they can be easily overridden. This one is the tricky one that may force us to go down the observer in the model/own class route.
	* Polymorphic relationships between posts/logs/announcements/wiki pages and comments works great with one caveat: if an admin overrides the model, that relationship fails, so those items wouldn't be able to pull back any existing comments. Likewise, any comments created with extended models wouldn't be available to the original model because of the way Eloquent handles tracking those items.
* Views
	* Status: COMPLETE
	* The view config file allows setting paths to the view directories to search. That's all that's needed in our case.
* Language
	* Status: COMPLETE

## Other Changes Made

* Added `app/controller` directory.
* Added `helpers.php` in the `nova` directory.
* Added `nova/start/bindings.php` to store all bindings to the container.
* Moved the content of `app/filters.php` to `nova/src/Nova/Core/filters.php`. Devs can add their own filters after the require statement in `app/filters.php`.
* Moved `vendor` to `nova/vendor` directory.
* Moved `bootstrap/autoload.php` to `nova/start/autoload.php`.
* Updated `index.php` with constants for base, app, nova and vendor paths.
* Updated `index.php` with URL constants for base, app and nova.
* Updated `nova/start.php` with a new config loader that'll pull and merge config files from all over the file system.
* Updated `nova/start.php` to bind the Location class to the App container.
* Updated `nova/start.php` to pull in the Nova helpers.
* Removed `app/controllers` directory.

## Questions

* What's the right place to call customized config loaders?
* What's the right place to call customized language loaders?

## Phing Job

* Pull from Github
* Run `composer install`
* Run all unit tests (on Nova only), break out if there are any failures
* Remove unnecessary files
	* .gitignore
	* app/tests
	* phpunit.xml
	* server.php
* Remove unnecessary files from the vendors
	* All of these files and directories should be stored in an array then looped through. Within the loop, we can run `rm -rf nova/vendor/**/[item]` to remove those from all vendor directories.
	* .git/
	* test/
	* Test/
	* tests/
	* Tests/
	* test-suite/
	* doc/
	* docs/
	* .gitignore
	* .gitattributes
	* phpunit.xml
	* phpunit.xml.dist
	* .travis.yml
	* readme.md
	* README.md
	* README.mdown
	* readme.mdown
	* README.git
	* license.txt
	* LICENSE
	* CHANGELOG.md
	* changelog.md
	* CHANGELOG.mdown
	* changelog.mdown
	* build.xml
	* VERSION
* Build and zip genres
* Upload to server
* Upload broadcast file