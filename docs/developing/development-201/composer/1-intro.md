# Intro to Composer

Composer is a PHP dependency manager. It lets you define the dependencies for your project and downloads them directly from (Packagist)[http://packagist.org] (it can accept other sources as well, but mainly uses Packagist).

It's important to note that Composer is not a _package manager_. It does deal with "packages" or libraries, but it manages them on a per-project basis by installing them into a single directory (by default, `vendor`) inside your project. By default, it will never install anything globally, thus, it's a _dependency manager_.

This idea is not new. Other languages have had similar tools for a while now, but there's never been such a tool for PHP. Composer aims to solve several problems:

- You have a project that depends on a number of libraries.
- Some of those libraries depend on other libraries.
- You declare things you depend on.
- Composer finds out which versions of which packages need to be installed and installs them (i.e. download them into your project).

It's a pretty simple and straightforward process. Let's get Composer installed and dig in to declaring some dependencies.

## Installing Composer

### Windows

If you're running Windows, you should just download the Composer installer from http://getcomposer.org/download. You can install Composer wherever you tell it or can choose to install it globally. If you install Composer globally, you won't have to go through the process of installing it each time you have a new project you want to use Composer for. We'll assume you have installed it globally for the remainder of this course.

### All Others

For anything other than Windows, everything can be done from the command line. Like the Windows version, you can find everything you need about installing composer at http://getcomposer.org/download. The simple instructions will cover most of your use cases for downloading and installing Composer. The only other thing you'll need to do is install Composer globally. Using the below command, you can do just that.

<pre>curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer</pre>

<p class="alert"><strong>Note:</strong> If the above fails due to permissions, runn the `mv` line again with `sudo`.</p>

Once these commands have been run, you'll be able to run Composer using `composer` instead of `php composer.phar`.