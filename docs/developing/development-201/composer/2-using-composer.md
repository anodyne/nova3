# Using Composer

Once Composer is installed, you simply need to know the name of the dependency your project requires, and you specify this dependency in a file called composer.json. The composer.json file also allows you to give your project a name, version and a few other details, which can be used to publish your own Composer packages to Packagist.

Once you’re happy with the dependencies you have defined; it’s time to install them. Go to your command line and type composer install. I typically add--no-dev because Composer will install development dependencies by default. If your dependencies will need to build or test themselves, it’s best to leave this out. Installing dependencies may take some time, but any indication of progress is a good sign. Get a cup of coffee and wait it out.

Composer will automatically download nested dependencies, and the more things it needs to download, the longer it will take to download them. When it’s done; it will also generate a decent class autoloader script. You can immediately start to use auto-loaded dependencies by including vendor/autoload.php in your PHP scripts.

The libraries you install with Composer are located in the same vendor folder, and Composer will also create a lock file which records the exact versions of your dependencies so that they can be installed in the same way on production servers.

If your favourite PHP framework installs with Composer; it probably includes this file for you.

If you are using a framework that doesn’t include the class autoload script, or no framework at all, you just need to include the vendor/autoloader.php file to be able to autoload your dependencies.