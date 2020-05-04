# Custom Icon Set

To demonstrate how to create a custom icon set to use in Nova 3, we're going to create a new icon set called Nova and step through the procedures one-by-one.

## Upload the files

1. Rename the `CustomIconSet` folder that you unzipped to the name of the icon set to `NovaIconSet`.
2. Upload the `NovaIconSet` folder to your `extensions` directory on the server. (Be mindful of casing and it will be very important in the next steps!)

_Note:_ We actually recommend storing your extensions in a unique folder name, often referred to as a "vendor" folder. For example, Anodyne extensions will instruct you to upload the extension to an `Anodyne` folder within your `extensions` directory.

## Update the icon set class

Next, we need to update the class in the extension to work with where you've uploaded the files.

1. Rename the `CustomIconSet.php` file to `NovaIconSet.php`.
2. Update the namespace in `NovaIconSet.php` to match the file structure where the extension lives. For example, if we were to add it a directory called `Acme`, the new namespace would be `Extensions\Acme\NovaIconSet`.
3. Update the name of the class in `NovaIconSet.php` to `NovaIconSet`.
4. Update the value in the `name` method to `Nova icons`.
5. Update the value in the `prefix` method `nova`. It's important that this is unique to other icon sets.
3. Save the file (and ensure it's been uploaded to the server).

## Update the service provider

Next, we need to update the service provider to ensure everything is wired up properly.

1. Update the namespace in `ServiceProvider.php` to match the namespace you set in the previous file.
2. In the `boot` method, update the class that's created to be `NovaIconSet`.
3. Save the file (and ensure it's been uploaded to the server).

## Adding icons

The icon set class defines a method called `map` which helps Nova map what it calls an icon to what the actual filename is. You'll need to go through this list and update all of the items in the map as you copy the icon files into the `icons` directory.

### Fill vs stroke icons



## Final NovaIconSet class

```php
<?php

namespace Extensions\Acme\NovaIconSet;

use Nova\Foundation\Icons\IconSet;

class NovaIconSet extends IconSet
{
    public function classes(): string
    {
        return 'fill-current';
    }

    public function map(): array
    {
        return [
            'activity' => '',
            'book' => '',
            'hide' => '',
            'notification' => '',
            'search' => '',
            'show' => '',
            'sidebar' => '',
        ];
    }

    public function name(): string
    {
        return 'Nova icons';
    }

    public function prefix(): string
    {
        return 'nova';
    }
}
```

## Final ServiceProvider class

```php
<?php

namespace Extensions\Acme\NovaIconSet;

use BladeUI\Icons\Factory;
use Nova\Foundation\Icons\IconSets;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{
    public function boot()
    {
        $set = new NovaIconSet;

        $this->app->make(Factory::class)->add($set->prefix(), [
            'path' => __DIR__ . '/icons',
            'prefix' => $set->prefix(),
        ]);

        $this->app->make(IconSets::class)->add($set->prefix(), $set);
    }
}
```