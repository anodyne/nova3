# PSRs

The PHP Framework Interop Group was formed to help create standards for PHP community projects. These standards help ensure that more and more projects are doing things the same way. This creates continuity between projects, makes it simpler to pick up and understand new projects and provides tools (like Composer) that can be used to inject framework-agnostic components into other projects.

Anodyne adheres to PSR-0 and PSR-1 for Nova 3, but we only have partial adherence to PSR-2 (see the coding guidelines document for a full list of what we do and don't adhere to for PSR-2). Any of the interface PSRs are handled by their respective components and don't have any impact on Nova.

## PSR-0: Autoloading

(View the full text of PSR-0)[http://www.php-fig.org/psr/0/]

PSR-0 establishes the way that projects should be organized and namespaced. Using standard conventions means that it's easier to understand how a namespace translates to a file structure. Using PSR-0 also allows for automatically handling class autoloading from the Composer autoloader.

With PSR-0, the namespace `Foo\Bar\Class` would translate to a file structure that looks like:

- Foo
	- Bar
		- Class.php

## PSR-1: Basic Coding Standards

(View the full text of PSR-1)[http://www.php-fig.org/psr/1/]

## Other PSRs

### PSR-2: Coding Style

(View the full text of PSR-2)[http://www.php-fig.org/psr/2/]

### PSR-3: Logger Interface

(View the full text of PSR-3)[http://www.php-fig.org/psr/3/]