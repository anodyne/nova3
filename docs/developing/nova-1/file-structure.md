# Nova 3's File Structure

A quick glance at Nova 3 and the file structure looks pretty similar to Nova 2, but once you start to poke around, you'll find that things are very different. So where will you find what? Use the guide below to help you navigate through the new file structure.

## Root Files

### composer.json

Laravel 4 is built on top of many framework-agnostic components built by the wider PHP community. Composer is the tool used to manage the dependencies between packages. Laravel uses it to make sure all the necessary pieces it needs are in place and Nova uses it to make sure the third-party components we use are available. In most cases, you should never have to modify this file, but if you do, it may be necessary for you to manually make changes to this file in the event we update the Composer dependencies for Nova, Laravel or any of the other components.

### index.php

The index file is the entry point into Nova. Everything starts and ends with the index file; constants used through the system are setup, Laravel's components are created and booted up for use by Nova, requests are executed and responses are sent. Since this is a critical file to the execution of Nova, you shouldn't be modifying it unless you know exactly what you're doing.

## App

* events.php
* filters.php
* macros.php
* routes.php

### assets

### config

### lang

### skins

### src

This is where your custom source code lives. There are folders for the app and for modules.

### start

As Laravel starts up, several files are called to help setup the system and boot the framework. If you need to change the way Laravel boots up or add service providers or anything else, you can do so in these files _after_ the `require` statements (these pull in base files from the Nova core).

### widgets

## Nova

Like previous versions of Nova, we _strongly_ discourage developers from modifying anything in these directories. Since this is part of the Nova core, if updates are made, these directories are what's changing. We've gone to great lengths to make sure that anything you will want to be modifying can be done from the `app` directory or from individual modules in `app/module`.

### assets

Javascript, image and CSS assets that Nova needs are stored here. This allows us to update these components without impacting individual games.

### config

### lang

### src/Nova

This directory contains the Nova core.

#### Api

Nova 3 includes a RESTful API for accessing information out of Nova into other websites, services and even mobile apps. More documentation is coming on this feature as it's written.

#### Core

The Nova core.

#### Extensions

Any overrides or changes that need to be made to Laravel or other components included through Composer to suit the way Nova 3 is setup are done in `Extensions`. __You should never modify anything in this directory as it can cause Nova to stop working entirely.__ Some of the things we change are:

##### Caralyst/Sentry

##### Laravel/Config

By default, L4 wants to store all of its config files in `app/config` and reference them from there. Unfortunately, Nova's setup means this can create problems with updating. To address this, we've written a new cascading config loader that looks in specific locations and combines config files into a final array. If you want to change something, you can change it in the `app/config` version of the file and it'll override what's set in the core.

##### Laravel/Database

Nova 3 uses a base model that provides all the models we create with a similar set of command. This means that if you know how to use the base methods in one model, those same methods exist everywhere else. The base model is stored in Extensions since it extends the Eloquent ORM model.

##### Laravel/Translation

Like the config loader, L4's translation code wants to pull from `app/lang`. While this is fine in most cases, it would create a nightmare for admins when updating the system. Like the config loader, we've created a cascading translation loader that pulls from a variety of locations and combines them together to provide Nova with the final translation array to use.

##### Laravel/Application

Laravel's application container manually uses a config loader instead of pulling from the IoC container. To get around this, we've had to extend the Application container and manually load our own config loader.

#### Forum

The Nova forums.

#### Setup

This module handles any and all setup concerns, be it installing a fresh copy of Nova, upgrading from Nova 2, updating to a newer version of Nova 3, adding genres, changing the database or anything else you might want to do.

#### Wiki

The Nova wiki.

### start

Used by Laravel during startup, these files are responsible for setting up the environment Nova operates in.

### storage

### tests

### vendor

This directory is used by Composer to store all the code of content pulled in through the Composer service. __You should never directly modify anything in this directory.__ If you need to change something, it can be done by modifying the `composer.json` file in the root directory.

### views