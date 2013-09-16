# PSR-0: Autoloader Standard

(View the full text of PSR-0)[http://www.php-fig.org/psr/0/]

PSR-0 establishes the way that projects should be organized and namespaced so that autoloading files is a breeze. Using standard conventions means that it's easier to understand how a namespace translates to a file structure. Using PSR-0 also allows for automatically handling class autoloading from the Composer autoloader.

With PSR-0, the namespace `Foo\Bar\Class` would translate to a file structure that looks like:

- Foo
	- Bar
		- Class.php

Laravel 4, the framework Nova 3 is built on, adheres to PSR-0. Any code submitted to Anodyne should also adhere to PSR-0.