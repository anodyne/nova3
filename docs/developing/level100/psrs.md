# PSRs

PHP has never truly had a uniform standard for writing code. Each developer tends to go their own direction with their coding standards, creating a mess of different styles and ways of doing things. In the wake of growing frustrations between frameworks and projects, the PHP Framework Interop Group was formed to help create standards for PHP community projects. These standards help ensure that more and more projects are doing things the same way. This creates continuity between projects, makes it simpler to pick up and understand new projects and provides tools (like Composer) that can be used to inject framework-agnostic components into other projects.

What came out of the PHP-FIG were a series of PSRs, or PHP Standards Recommendations. As of today, there are 4 PSRs.

## PSR-0: Autoloader Standard

(View the full text of PSR-0)[http://www.php-fig.org/psr/0/]

PSR-0 establishes the way that projects should be organized and namespaced so that autoloading files is a breeze. Using standard conventions means that it's easier to understand how a namespace translates to a file structure. Using PSR-0 also allows for automatically handling class autoloading from the Composer autoloader.

With PSR-0, the namespace `Foo\Bar\Class` would translate to a file structure that looks like:

- Foo
	- Bar
		- Class.php

Laravel 4, the framework Nova 3 is built on, adheres to PSR-0. Any code submitted to Anodyne should also adhere to PSR-0.

## PSR-1: Basic Coding Standard

(View the full text of PSR-1)[http://www.php-fig.org/psr/1/]

PSR-1 focuses on basic coding styles, specifically refraining from being too specific. These rules are there to ensure a high level of technical interoperability between shared PHP code.

Nova 3 fully adheres to PSR-1. Any code submitted to Anodyne should also adhere to these standards.

## PSR-2: Coding Style Guide

(View the full text of PSR-2)[http://www.php-fig.org/psr/2/]

PSR-2 expands on PSR-1 by defining coding styles to be used by projects. Because of differences in opinion between what "looks" best when it comes to coding styles, many projects don't fully adhere to PSR-2.

Anodyne's coding style guidelines are slightly different and therefore do not comply with PSR-2. Any code submitted to Anodyne should adhere to our coding style, not PSR-2.

## PSR-3: Logger Interface

(View the full text of PSR-3)[http://www.php-fig.org/psr/3/]

PSR-3 describes a shared logging interface, incorporating the eight Syslog levels ((RFC 5424)[http://tools.ietf.org/html/rfc5424]): debug, info, notice, warning, error, critical, alert and emergency. Since Laravel 4 uses Monolog and Monolog adheres to PSR-3, Nova 3 does in fact adhere with PSR-3.