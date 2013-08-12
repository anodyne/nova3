# Overriding an Existing Page

Nova comes with a lot of pre-built pages that provide a wide range of functionality. In some cases though, you may want to change the way that a core page behaves. Using Nova's Routes Manager, you can tell Nova to use a completely different resource for a given page with only a few steps.

Let's say we want to make a few changes to the main page and add some fancy artwork that we did in Photoshop. To do that, we need to first create a new controller. For simplicity, we'll just create it in the `app/controllers` directory and name it with the name of our game.

<pre>&lt;?php namespace App\Controllers;

use MainBaseController;

class Enterprise extends MainBaseController {
	
	public function getMainPage()
	{
		$this->_view = 'enterprise/main';
	}
	
}
</pre>

Believe it or not, that's actually all we need in the controller. Nova takes care of everything else for us. The only thing we need to do now is to create our view file. In `app/modules/override/views/components/page` we're going to create a new directory called `enterprise` and in there, create `main.blade.php`.

<pre>&lt;!-- Do your fancy coding here --></pre>

Done.

The beautiful part about some of Nova's new features is that your page automatically gets the site content from the core page, so your page title, header and intro message will all be the same. We're not done yet though, because Nova doesn't know when to call this controller action. In order to tell Nova how to do that, we're going to duplicate the `main/index` route from the Routes Manager (in the Core Routes tab). When the page refreshes, you'll see the `main/index` route in your user-created routes. Edit the route and change the following information:

- Resource: App\Controllers\Enterprise@getMainPage

Head over to your browser and go to `http://yoursite/`. If all goes well, you should see the changes you made in your view file. You can also do any PHP calculations or database calls you want in the controller and pass them to the view through the `$this->_data` object.