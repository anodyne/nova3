# DevCenter

DevCenter is an exhaustive resource for everything about developing for Nova 3. Here you'll find topics ranging from the simplest to highly advanced topics for the bravest of 3rd party developers. This is the best place to start if you want to understand and start developing for Nova 3.

## Development 101

This track is meant for people who have little to no experience with PHP. Through several courses, you'll learn about what PHP is, what it can do, how to write it and move all the way up to some of the more advanced features of the language.

- Intro to PHP
	- [What is PHP?](development-101/php-1/1-intro.md)
	- [Declaring variables](development-101/php-1/2-variables.md)
	- Arrays
	- Comparisons
	- Looping
- Intermediate PHP
	- Intro
	- Functions
	- Objects and Classes
	- Object-oriented programming
	- Using databases
- Advanced PHP
	- Intro
	- Namespaces
	- Traits
	- Closures
	- Late static binding
	- http://net.tutsplus.com/tutorials/php/from-procedural-to-object-oriented-php/

## Development 201

With a more complete understanding of PHP, it's time to step up to some of the underlying technologies in Nova 3. Before you can take full advantage of those tools, you need to understand them.

- The PSRs
	- What are PSRs?
	- PSR-0
	- PSR-1
	- PSR-2
	- PSR-3
- Laravel 4
	- Intro to Laravel 4
	- Installing Laravel 4
	- Important Concepts
	- Laravel 4 basics
- Composer
	- What is Composer?
	- Installing Composer
	- Composer basics
	- Using Composer components

## Nova Development Level 1

- Anatomy of Nova 3
	- How it's all put together
	- Application flow
	- Where are things located
		- By now, you've gotten used to where everything is in Nova 1/2, but with Nova 3, nothing will look the same, so let's dive in and figure out where some of the important things are in Nova 3.
	- Routing
- Controllers
	- Intro
		- What is a controller?
		- What is Nova's controller philosophy?
	- Base Controllers
		- The base controller
		- Section base controllers
	- The makeup of a controller
	- Creating new controllers
	- Extending existing controllers
- Emails
	- Intro
	- How does Nova handle email?
	- What are the emails Nova sends out?
	- Changing existing emails
	- Creating new emails
- Widgets
	- What are widgets?
	- Creating widgets for use in Nova
- Modules
	- What are modules?
	- How Nova uses modules
	- Creating your own module
	- Migrations
- Access control
	- How does access control work?
	- Integrating access control into custom solutions
- Tools for Developers
	- Seamless substitution
	- QuickInstall
	- Interfaces
		- Overview
		- The Media interface
		- The QuickInstall interface
	- Support libraries
		- Location
		- Status
		- ErrorCode

## Nova Development Level 2

- Intro to Database Interaction
	- The Eloquent ORM
		- Basic functions
		- Collections
	- Models
	- Validators
- Caching
	- What is caching?
	- How does Nova use caching?
	- Leveraging model events to re-cache content
	- APC and Memcache
	- Caching for custom solutions
- Events
- Architecture
	- Service Providers

## Nova Development Level 3

- Advanced Controllers
	- Injecting dependencies
	- Filters
	- Interfaces, Implementations and Injection
- Advanced Models
	- Model events
	- Creating new models
	- Overriding existing models
	- Repositories and Interfaces
- Dynamic Forms
	- So you want to hook your dynamic form into a custom database table?

## The Nova API