# QuickInstall Interface

## The Interface

<pre>interface QuickInstall {
	
	/**
	 * Install the item.
	 *
	 * @param	mixed	The location of the item or FALSE to install everything.
	 */
	public static function install($location = false);

	/**
	 * Uninstall the item.
	 *
	 * @param	string	The location of the item.
	 */
	public static function uninstall($location);

}</pre>

## Using the Interface

In order to use the QuickInstall interface, simply call the `QuickInstallInterface` class on your model or class.

<pre>class YourModel extends \Model implements \QuickInstallInterface</pre>

<p class="alert alert-info"><strong>Note:</strong> The forward slash is due to the fact that your model or class will most likely be inside of a namespace that can't see the `QuickInstallInterface`. You can also add _using_ statements at the top of your file to avoid using the forward slash.</p>

<pre>use Model;
use QuickInstallInterface;

class YourModel extends Model implements QuickInstallInterface</pre>

### `install()`

### `uninstall()`