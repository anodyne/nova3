# Page Routes

Nova has always provided the ability for developers to override pages that already exist in Nova with their own versions. This flexibility allows Nova to be modified for just about any purpose you can think of, even if that page already exists in the Nova core.

For Nova 3, we've exposed the routing system of Nova's foundation with a powerful and easy-to-use Page Manager that provides you more flexiblilty with overriding Nova's core pages. With the new Page Manager, you can easily manage the page routes used by Nova, duplicating a core page route (you can't delete the core page routes) and making any changes you want so when someone goes to your `main/credits` page, instead of seeing the page from the Nova core, they see your custom page instead. This provides you with significantly more control and freedom to make non-destructive changes to Nova to suit your game.

## What is a route?

So what the hell is a "route" anyway? Simply put, a route is an instruction to Nova's foundation about what class and method to use when a specific URL is visited. When someone goes to your site's `main/credits` page, Nova checks the declared routes to figure out what controller and what method to use then calls those items and renders the output to the user's browser.

Pretty simple.

So what does a route look like anyway?

<pre>Route::get('main/credits', 'Nova\Core\Controller\Main@getCredits');</pre>

For some, this may look very straightforward, while for others, it might as well be Greek. This is where Page Manager comes in so handy. You won't ever have to know how to declare a route because Page Manager will walk you through each step of the process and create the route for you.

## Route Verb

It may seem like a funny idea, but routes have verbs associated with them, or in other words, actions. The verbs available to be used by a route are the basic HTTP verbs: `GET`, `POST`, `PUT` and `DELETE`.

For anyone who's done even a little bit of web development, `GET` and `POST` should be familiar to you. `PUT` and `DELETE` are the same concept, just for updating and deleting items respectively. Nova's routing system will allow you to create routes specific for each of those verbs. If you aren't sure about whether to use `POST`, `PUT` or `DELETE`, you can use `POST` for all of them.

## Route Resource