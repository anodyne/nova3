# Creating a New Page

Let's say you want to create a brand new page to display the awards your game has received over the last year. Using the Routes Manager, you can easily create a new page to do just that.

The first thing we need to do is create a new controller. For simplicity, we'll just create it in the `app/src/App/Controllers` directory and name it with the name of our game.

<pre>&lt;?php namespace App\Controllers;

use MainBaseController;

class Enterprise extends MainBaseController {
	
	public function getAwards()
	{
		$this->_view = 'enterprise/awards';
	}
	
}
</pre>

Believe it or not, that's actually all we need in the controller. Nova takes care of everything else for us. The only thing we need to do now is to create our view file. In `app/src/Modules/Override/views/components/page` we're going to create a new directory called `enterprise` and in there, create `awards.blade.php`.

<pre>&lt;!-- List out your awards here--></pre>

Done.

The beautiful part about some of Nova's new features is that your page now has the ability to tap into the Site Contents feature as well. You can create a header, page title and intro message all from the Site Contents page in the admin section and that content will appear in your page just like it does on other Nova pages.

We're not done yet though, because Nova doesn't know when to call this controller action. In order to tell Nova how to do that, we're going to create a new system route from the Routes Manager and put in the following information:

- Name: simawards
- URI: simawards
- Resource: App\Controllers\Enterprise@getAwards
- HTTP Verb: get

Create the route and then you can head over to your browser and go to `http://yoursite/simawards`. If all goes well, you should see the list of awards that you created in your view file.

## Other Options

### Site Content

You can tap in to Nova's Site Content feature for your page by simply creating new records in the Site Content management page for the page header, page title and intro message. Next time you hit the page, you'll see your title, message and header there, without ever having to hard-code them into the view or controller method.

### Make It More Dynamic

You can make your page a little more dynamic and store your awards by the year they were won by the game. To do that, we're going to make a few changes.

First, change the system route for your page to include a year variable in the URI: `simawards/{year}`.

Next, we're going to add the year parameter to our controller method and then pass that variable to the view.

<pre>public function getAwards($year = 2013)
{
	$this->_view = 'enterprise/awards';

	$this->_data->year = $year;
}</pre>

Now that our view knows about the year variable, we can change the view to use it.

<pre>@if ($year == 2013)
	&lt;-- 2013 awards here-->
@elseif ($year == 2012)
	&lt;-- 2012 awards here-->
@else
	No awards won before 2012
@endif</pre>

Hit the page again and you'll see the 2013 awards. If you go to `http://yoursite/simawards/2012` then you'll see the 2012 awards instead of 2013.