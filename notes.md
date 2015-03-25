# Extensions

- Should an extension be able to override view files?
	- Pros
		- A lot easier and more contained for developers to override the existing stuff if they can do it from right within their extension instead of having to provide instructions for moving a file to the Override extension
	- Cons
		- If something blows up, there are now a lot more places where an admin needs to look in order to figure out what could be causing something to have issues
- Should an extension be able to declare routes in a file instead of in the database?
	- Pros
		- Much easier for developers to just declare a couple of routes in a file and be done with it
		- Faster
	- Cons
		- No Page Manager record means that some stuff would break
		- Admins won't be able to see ALL pages that are declared in the Page Manager
		- Could possibly overwrite an existing page and cause issues, forcing admins to search through all the extensions