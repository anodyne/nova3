# Routing in Nova 3

Laravel 4 comes with a robust routing system that's built on top of Symfony's HTTP Foundation component. Unfortunately though, Laravel 4 _requires_ that routes be explicitly created (in other words, you have to know what every URI is and write something for each page). Our goal with Nova 3 was to reduce the complexity wherever possible and using such a strict routing system was a dealbreaker for us. Thankfully, Laravel's structure has allowed us to tweak the Laravel router to suit our needs, but it does lead to a few things that are important to highlight.

## The Routing Flow

Much like seamless substitution, Nova's routing flow checks throughout the system to find the right controller action to use for a requested page.

1. The App
	- Nova will look for controllers with a namespace of `App\Controller` first. If one is found, the execution is stopped and that's used. So if you wanted to replace `sim/index` with your own version, you'd create a `Sim.php` file in `app/controller` with a namespace of `App\Controller`. In that file, you'd need to have the appropriate controller action (`getIndex()` in this case) and when Nova's router finds that, it'll use it.
2. Modules
	- Nova will look through all of the installed modules for a controller that matches. Module controllers must have a namespace of `Module\Test\Controller`. So if you wanted to replace `sim/index` with your own version from a module, you'd create a `Sim.php` file in `app/module/test/controller` with a namespace of `Module\Test\Controller`. In that file, you'd need to have the appropriate controller action (`getIndex()` in this case) and when Nova's router finds that, it'll use it.
3. The Core
	- If the controller isn't found in `app` or `app/module`, then Nova falls back to the core to find the controller and use it.
4. Explicit Routes
	- If all else fails, Nova will look for the URI among explicitly created routes (the Setup module, for example, doesn't use controllers, only explicitly created routes).

If, after going through the above checks, Nova _still_ can't find a controller matching the URI, a 404 is thrown.

## RESTful Controller Actions

In previous versions of Nova, controller actions haven't been prefixed with anything. While this is fine for some things, there are times where you might want to create a page but can't because it conflicts with a reserved word in PHP. One of the best examples of this is trying to create a list of something, except `list()` is a function in PHP, so you can't use it unless it's prefixed. In Nova 3, we've taken that one step farther to provide RESTful controller actions so that each action can have its own controller method.

"Why the hell would you do that?" you ask? It creates greater separation of the various operations in a controller. If you want to just change how a rank item is created, you can actually target that specifically without ever touching anything to do with updating, deleting or displaying.

### GET

The default behavior for a web request is `GET`. If you want to create a page that simple displays something for the user, you could create a controller action with the name `getShow()`. That would respond to a URI like `controller/show`.

### POST

Posting to a page is a common action on the web, but in reality, a `POST` request is only meant to be used for _creation_ though modern browsers use it for everything other than `GET`. If you want to build a form on your page that allows users to add something to the list, you can create a controller action with the name `postShow()`. That method would respond to a URI like `controller/show` but _only_ for `POST` requests.

### PUT

Unlike `POST`, a `PUT` request is used for updating something. The only issue now is that modern browsers don't natively recognize a `PUT` request. Using a little trickery, Laravel is able to make a browser thing it's getting a `PUT` request. If you want to build a form on your page that allows a user to update something, you can create a controller action with the name `putShow()`. That method would respond to a URI like `controller/show` but _only_ for `PUT` requests.

### DELETE

Finally, like its name suggests, a `DELETE` request is used for deleting something. If you want to build a form on your page that allows a user to delete something, you can create a controller action with the name `deleteShow()`. That method would respond to a URI like `controller/show` but _only_ for `DELETE` requests.

### The Gotcha

The only gotcha involved with this is if you're allowing a user to do multiple actions at the same time. Since we can only assign one action per form, you could put all those actions into a `postShow()` method and take the necessary actions within that method.

## Example

The following is an example controller showing the different methods.

<pre>class Test extends Controller {

	public function getIndex()
	{
		// Show an index page
	}

	public function postIndex()
	{
		// Process an addition request from the main page

		return Redirect::to('test/index');
	}

	public function getEdit()
	{
		// Show an edit page
	}

	public function putEdit()
	{
		// Process an update request from the edit page

		Redirect::to('test/edit');
	}

	public function getDelete()
	{
		// Show an edit page
	}

	public function deleteDelete()
	{
		// Process a delete request from the delete page

		Redirect::to('test/edit');
	}
}</pre>