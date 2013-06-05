# Page Routes

Nova has always provided developers the ability to override any page that already exist in the Nova core with their own versions. This flexibility allows Nova to be changed for just about any purpose you can dream up. With Nova's previous underlying framework, this process was relatively simple, but it required us to impose strict rules on how to override core pages. In Nova 3 however, we're able to provide significantly more freedom in the way you change core pages.

## Routing: A Primer

If you've ever overridden a controller method or created a new controller method in previous versions of Nova, you've inadvertently dealt with the routing system. Routing is a very simple concept:

- A user types in a URL to their browser (or clicks a link to that URL).
- The server takes the URI (i.e. main/index) and passes that to the framework Nova runs on.
- The framework parses the URI into a controller (a PHP class - Main.php in the controllers directory in this case) and a method within that class (index) and calls the combination of those.
- The resulting output is sent back to the browser and displayed to the user.

While there are more advanced routing options in the underlying framework, because of the confusion it would've created, we didn't use it, relying instead on the simple parsing of the URI.

## Routing in Nova 3

In Nova 3, we've changed the underlying framework to a much newer and more advanced PHP framework. Not wanting to impose limitations or guidelines on developers, the framework demands a more hands-on approach to routing. In fact, the new framework _requires_ that every page in the system be explicitly routed. This posed an interesting challenge for us. On the one hand, it's a powerful system, but it would've required editing PHP files every time someone wanted to create or change page (regardless of whether it was a core page or not). That wasn't an ideal situation.

The first solution was to build our own router that worked exactly like previous versions of Nova. This was the ideal situation since it lowered the learning curve and stayed highly dynamic. We were able to build the router exactly the way we wanted: the Nova core would take a URI and parse it, checking through a wide range of locations to make sure developers could override pages from several different places. This worked perfectly, but as development ramped up, we began to see a negative impact on performance. The more we added to Nova, the slower things got. This wasn't ideal.

The only solution was to move back to the built-in routing system, but as we were sorting through those details, an idea came to us and the Routes Manager was born, a simple and powerful user interface for creating, duplicating and modifying routes so that developers can change the controller and method that any page in the system points to. This gives you ultimate flexibility to change whatever you want and expand Nova in any way imaginable in a non-destructive way. If something doesn't work or you want the default behavior back, you can simple remove your route and Nova will fallback to use the route from the core.

## Routing Terminology

Now that we've explained how the routing system works, it's important that everyone is on the same page with the terminology so that when you make changes to routes, you know what is what.

### Route

Simply put, a route is an instruction to Nova's underlying framework about what class and method to use when a specific URL is visited. When someone goes to your site's `main/credits` page, Nova checks the declared routes to figure out what class and what method to use then calls those items and renders the output to the user's browser.

### HTTP Verb

Requests fall into one of four categories, or verbs: `GET`, `POST`, `PUT` and `DELETE`.

The simplest of these verbs is `GET` and is pretty self-explanatory. When you type in the URL into your browser, you're executing a `GET` request. The browser is simply _getting_ something back from the server without providing it any more than a URL.

The next most common verb is `POST`. When you fill out a form on a web site and hit the Submit button, you're handing the content of the form back to the server in the hopes of doing something with it. You'll usually get something back from the server, but the important piece is that you're _posting_ to the server. `POST` requests can cover everything from adding a new entry to a database table, editing an existing entry or even deleting something.

While less common on the web today (mainly because some browsers don't fully support them natively), the `PUT` and `DELETE` requests are identical to `POST` except for their purpose. A `PUT` request assumes that you're updating an existing item and a `DELETE` request expects that you're deleting something.

### Resource

There are two pieces to every route: the class and the method. These two items are pieced together with a simple `@` to tell the framework where the class ends and the method begins. If you have a controller named `Foo` in the `app/controller` directory and a method called `getIndex` in that controller, your resource would be `App\Controller\Foo@getIndex`.

#### Class

The class in a resource can be any PHP class. It can be kept anywhere you want. This means there are no standards imposed on you with how you organize your code. If you want to create a module that has a `controllers` directory, you can do that. If you'd prefer to put them in the root of the module, that's fine too. (Developers should see the overview about developing for Nova 3 for more information.) The biggest thing to remember when declaring a resource class is that you have to provide the fully-qualified class name with its namespace.

#### Method

Like the classes, your methods can use whatever naming conventions you want. In Nova 3, we've chosen to prefix the methods with their HTTP verb so its easier to see what the method does at first glance, but you aren't tied to that naming scheme for your own controller methods.