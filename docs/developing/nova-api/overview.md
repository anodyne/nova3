# The Nova API

Nova 3 includes a RESTful API that developers can use to tap in to Nova's data and even create, edit and delete data as well. The use cases for a full RESTful API are broad and we're sure developers will come up with some creative ways to use it!

## API Info

The API includes a basic information call that will return the API version, the version of Nova and the base URL of Nova as a JSON object. This can be very helpful if you're targeting a specific version of Nova or a specific version of the API.

<p class="alert alert-info">In these examples, we're using the fictional <code>nova3.dev</code> URL. You'll need to replace that URL with your own.</p>

<pre>curl nova3.dev/api/v1/info

{
	"api_version": "v1",
	"nova_version": "3.0",
	"nova_url": "http://nova3.dev/"
}</pre>

## Authentication

Some calls to the API require authenticating to the system, much like logging in to view admin functions. Anything that modifies the database requires that you authenticate to Nova. Doing so is easy.

<pre>curl --user me@example.com:password nova3.dev/api/v1/users</pre>

Since an API is meant to be stateless, there is no way to be "remembered" by the API for future calls; you have to authenticate for each request you send that requires authentication. If you make a call to a protected API method and you don't authenticate, you'll get an "Unauthorized" response.

## Authorization

Some calls to the API not only require authenticating to Nova, but also being authorized to take that action. The authorization system used by the API is the same used throughout Nova. If you have permission to do something in the browser, you can do it through the API.