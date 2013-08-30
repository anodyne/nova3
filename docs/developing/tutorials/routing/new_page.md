# Creating a New Page

Let's say your simming organization has published a list of fleet rules and wants every game to display them on their site. You could pretty easily copy those rules and put them into a wiki entry, but unless your organization is telling you every time there's a change, you could easily end up with a wrong set of rules on your site. Instead of keeping those rules updated manually, let's create a new page that pulls in a text file from the simming organization's site and displays the content in your site.

We're going to make this a module so that we can send it to other game masters in the organization with Nova 3. To start, let's create a new directory inside `app/module` and call it `FleetRules`. We'll need a few more directories and files while we're at it:

- Create a directory called `controllers`
- Create a file called `Sim.php` inside the `controllers` directory
- Create a series directories so you have `views/components/page/sim`
- Create a file called `fleet_rules.blade.php` inside `views/components/page/sim`

Let's dig in to our controller now. Open up the `Sim.php` file and paste the following code into the file:

<pre>&lt;?php namespace Modules\FleetRules\Controllers;

use File;
use Markdown;

class Sim extends \Nova\Core\Controllers\Sim {
	
	public function getRules()
	{
		// Set the view file
		$this->_view = 'sim/rules';

		// Get the text file from the fleet server
		$rulesFile = File::getRemote('http://example.com/files/fleet_rules.txt');

		// Run the text through the Markdown parser
		$this->_data->rules = Markdown::parse($rulesFile);
	}

}</pre>

- The namespace is going to help tell Nova where this file is located. The `Modules` namespace actually points to `app/modules`, after that it's simply the file structure we have in place.
- We've chosen to `use` the `File` and `Markdown` classes. If we didn't do that, we'd have to prefix each call with a slash: `\File`. This is simply done for readability.
- We extend from the base `Sim` class so that we get all of the advantages of using the Nova core.

On to the view file, called `rules.blade.php` and put into `app/modules/fleetrules/views/components/page/sim`.

<pre><h1>Fleet Rules</h1>

{{ $rules }}</pre>

There are a few ways to route directly to this page.

- Create a new entry in the Routes Manager (fine if this is just for your game)
- Create a migration that creates the route in Routes Manager for the user (good in the event you're distributing the module)
- Create a routes file

### Create an entry in the Routes Manager

### Create a migration

### Create a routes file

Create a new file called `routes.php` at the root of your module.

<pre>&lt;?php

Route::get('sim/fleet_rules', 'Modules\FleetRules\Sim@getRules');</pre>

That's it. Fire up your browser and navigate to `[yoursite]/sim/fleet_rules` and check out your new page!