# Routing for Developers

## The Nitty Gritty

Now that you know what a route is and some of the pieces involved, let's get down to the nitty gritty of how exactly a route is declared. (You won't ever have to do this, but this might help solidify the concepts further when you're thinking about routes.)

The simplest of routes is declared like this:

<pre>Route::get('credits', 'nova\core\controllers\Main@getCredits');</pre>

The means that when someone hits `credits` on your site, Nova is going to call the class `Main` and the method `getCredits`. That's it. What happens then depends on the `getCredits` method.

Sometimes though, you'll want to post information back to your Nova site. For situations like that, you'll want to create a `POST` request, which is done like this:

<pre>Route::post('contact', 'nova\core\controllers\Main@postContact');</pre>

Like the first example, this is pretty simple and straightforward and means that when someone makes a `POST` request (like say, hitting the Submit button the contact page), the resource defined here will be called. This type of granularity allows developers to change specific pieces of Nova without touching others. For example, if you wanted to change what happens when the contact form is submitted, but not touch the display of the contact form, you could override just the `contact` request for posting information.

Parameters in the URL can be pretty common and the routing system has a way of handling those as well:

<pre>Route::get('character/{id}', 'nova\core\controllers\Personnel@getCharacter');</pre>

When someone goes to `character/1`, Nova will use the `getCharacter` method and pull up that character bio for the user to see. The `{id}` tells the router that we're going to have a parameter called ID in the URL and that it's required to be there. Over in the controller, our method would look something like this:

<pre>public function getCharacter($id)
{
	// Do something
}</pre>

You see there how the name of the parameter and the first parameter in our code match up? It's that easy! But what if we don't want a parameter required?

<pre>Route::get('character/{id?}', 'nova\core\controllers\Personnel@getCharacter');</pre>

The use of the question mark tells the router that that specific parameter is optional. (You'll need to make sure you also provide a default value for the parameter in your code.)

## Overriding an existing page

### What about when there's already a page overriding the page I want to override?

## Modules and Routing