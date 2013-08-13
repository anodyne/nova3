## Latest `laravel/laravel` Commit

* 07/30/2013
* 6a2ad475cfb21d12936cbbb544d8a136fc73be97

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

* Exceptions
	* Status: IN PROGRESS
	* Need to set up error handlers for different types of exceptions. This type of thing would allow specific error pages for specific types of exceptions and even allows cascading error handlers too.
		* 404 (Completed)
		* 500
		* Database error
		* General exceptions
		* Runtime exceptions

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