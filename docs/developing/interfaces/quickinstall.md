# QuickInstall Interface

- There are no requirements for any fields that _must_ be part of your QuickInstall file.

In order to use the interface, simply call the `QuickInstallInterface`.

<pre>class YourModel extends \Model implements \QuickInstallInterface</pre>

Note: The forward slash is due to the fact that your model will most likely be inside of a namespace that can't see the `QuickInstallInterface`. You can also add _using_ statements at the top of your file to avoid using the forward slash.

<pre>use Model;
use QuickInstallInterface;

class YourModel extends Model implements QuickInstallInterface</pre>

## `install()`

## `uninstall()`