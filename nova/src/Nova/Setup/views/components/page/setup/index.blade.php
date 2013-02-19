@if ($option == 1)
	<p>Nova 3 is a dynamic, database-driven web system which means, you guessed it, I need to install the database now. Start to finish, the installation should only take a few minutes to complete and then you'll be on your way. If you have questions, you can refer to <a href='http://docs.anodyne-productions.com' target='_blank'>AnodyneDocs</a> or drop in to our <a href='http://forums.anodyne-productions.com' target='_blank'>forums</a>.</p>

	<p>The links below provide information about how to install Nova 3 as well as a brief tour of some of Nova's major features. If you have additional questions, please visit the <a href="http://forums.anodyne-productions.com" target="_blank">Anodyne forums</a> for more help.</p>

	<p>Let's get started now...</p>
	
	<a href="#" target="_blank" class="btn-alt">
		<span class="secoptions-guide">Nova 3 Installation Guide</span>
	</a>
	
	<a href="#" target="_blank" class="btn-alt">
		<span class="secoptions-tour">Take a tour of Nova</span>
	</a>
@elseif ($option == 2)
	<p>Like previous versions of Nova, Nova 3 is a dynamic, database-driven web system which means, you guessed it, I need to install the Nova-specific database pieces now and then migrate most of your Nova data to the newer Nova 3 format. Start to finish, the upgrade should only take a few minutes to complete (probably about 10 minutes depending on your Internet connection) and then you'll be on your way.</p>

	<div class="alert alert-block alert-info">
		<h4 class="alert-heading">A Few Notes Before Starting</h4>

		<p>If your host has imposed limits on the size of your database, you may not be able to upgrade to Nova 3. In order to preserve your original data, big portions of the database are duplicated. If you have size limits on your database, please make sure the upgrade will not put your over those limits before you begin.</p>

		<p>We've written an exhaustive <a href="#">upgrade guide</a> that walks you through the process of moving from Nova 2 to 3. Make sure you've read through that document in its entirety before attempting to upgrade your game.</p>

		<p>Last (but certainly not least), make sure you've backed up your Nova files and database before you get started. Files can be backed up by downloading through your FTP client to a folder on your desktop. The database will have to be backed up by exporting the database tables in phpMyAdmin (likely reachable through your cPanel). If you have questions about how to do these things, check with your host.</p>
	</div>
	
	<a href="#" target="_blank" class="btn-alt">
		<span class="secoptions-guide">Nova 2 &rarr; Nova 3 Upgrade Guide</span>
	</a>
	
	<a href="#" target="_blank" class="btn-alt">
		<span class="secoptions-tour">Take a tour of Nova</span>
	</a>
@elseif ($option == 3)
	<p>It isn't enough to just release powerful, easy-to-use software, you also need to maintain it. Our goal is to continually make Nova better than it was before, be it fixing bugs or adding new features. The best way to make sure you're getting the most out of Nova is to keep up with the updates that we release.</p>
	
	<p>The links below provide information about how to update Nova 3 as well as the changelog for Nova. If you have additional questions, please visit the <a href="http://forums.anodyne-productions.com" target="_blank">Anodyne forums</a> for more help.</p>

	<p>Before you begin though, it's <strong>highly</strong> recommended that you backup both your files and your database. At Anodyne, we make sure to test all of the Nova updates before releasing them, but there is only so much we can test for. In the end, it's better to be safe rather than sorry.</p>
	
	<a href="#" target="_blank" class="btn-alt">
		<span class="secoptions-guide">Nova 3 Update Guide</span>
	</a>
	
	<a href="#" target="_blank" class="btn-alt">
		<span class="secoptions-history">See what's changed</span>
	</a>
	
	<hr>
	
	<h2>{{ $update->version }}</h2>
	
	<p>{{ $update->description }}</p>
@elseif ($option == 4)
	<dl>
		<dt><a href="{{ URL::to('setup/update/index') }}" class="btn-alt"><span class="secoptions-update">Update Nova</span></a></dt>
		<dd>Stay up to date with updates to Nova that fix bugs and add functionality. Even if your server doesn't allow for checking for updates, you can start the update process from here and be up and running on the latest version of Nova in only a few minutes.</dd>
		
		<dt><a href="{{ URL::to('setup/utility/genre') }}" class="btn-alt"><span class="secoptions-genre">The Genre Panel</span></a></dt>
		<dd>Nova has a flexible genre system that allows the system to be used for a wide range of games. Using the Genre Panel you can change your game's genre to one of the other provided genres. <strong>Be warned:</strong> if you change the genre, you'll likely have to do a healthy amount of manual work to change your characters to have the proper positions and ranks.</dd>
		
		<dt><a href="{{ URL::to('setup/utility/database') }}" class="btn-alt"><span class="secoptions-database">Database Change Panel</span></a></dt>
		<dd>Nova's structure allows for creating MODs that modify existing functionality, or sometimes, even add whole new sets of features. Some of the MODs you may encounter may require changes to the database. Using the Database Change Panel, you can make those changes quickly and easily with a simple user interface. <strong>Be warned:</strong> you're still modifying the database, so use caution and always make sure you have a backup!</dd>
		
		<dt><a href="{{ URL::to('setup/utility/remove') }}" class="btn-alt"><span class="secoptions-remove">Uninstall Nova</span></a></dt>
		<dd>If you want to completely uninstall Nova, you can do so with the uninstall option. <strong>Be warned:</strong> this action is permanent and cannot be undone. You will lose all data in the Nova database. Make sure this is what you want to do and that you have a backup before uninstalling. Also note that this will not delete any Nova files.</dd>
	</dl>
@elseif ($option == 5)
	<p>It looks like you're running Nova 1 on your site right now. Unfortunately, there's no direct upgrade path from Nova 1 to Nova 3. In order to get up and running (with all of your Nova 1 data) on Nova 3, you'll need to first update from Nova 1 to Nova 2. Once you're done with that (you don't need to worry about MOD/skin updates) you'll be able to upgrade from Nova 2 to Nova 3.</p>
	
	<a href="#" target="_blank" class="btn-alt">
		<span class="secoptions-guide">Nova 1 &rarr; Nova 3 Upgrade Guide</span>
	</a>
	
	<a href="#" target="_blank" class="btn-alt">
		<span class="secoptions-tour">Take a tour of Nova</span>
	</a>
@endif