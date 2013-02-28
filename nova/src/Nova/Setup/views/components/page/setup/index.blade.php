@if ($option == 1)
	<p>Nova 3 is a dynamic, database-driven web system which means there's some work to do before you can use it. Start to finish, the installation should only take a few minutes to complete and then you'll be on your way. If you have questions, you can refer to <a href='http://docs.anodyne-productions.com' target='_blank'>AnodyneDocs</a> or drop in to our <a href='http://forums.anodyne-productions.com' target='_blank'>forums</a>.</p>

	<p>The links below provide information about how to install Nova 3 as well as a brief tour of some of Nova's major features. If you have additional questions, please visit AnodyneDocs or the Anodyne forums for more help.</p>

	<div class="row-fluid">
		<div class="span3">
			<a href="#" target="_blank" class="btn btn-block">Nova 3 Install Guide</a>
		</div>

		<div class="span3">
			<a href="#" target="_blank" class="btn btn-block">Take a tour of Nova 3</a>
		</div>

		<div class="span3">
			<a href="#" target="_blank" class="btn btn-block">AnodyneDocs</a>
		</div>

		<div class="span3">
			<a href="http://forums.anodyne-productions.com" target="_blank" class="btn btn-block">Anodyne Forums</a>
		</div>
	</div>
@elseif ($option == 2)
	<p>Nova 3 is a dynamic, database-driven web system which means, you guessed it, I need to install the Nova-specific database pieces now and then migrate most of your Nova data to the newer Nova 3 format. Start to finish, the migration should only take a few minutes to complete (depending on your Internet connection and how much data you have) and then you'll be on your way.</p>

	<blockquote>
		<h4>A Few Notes Before Starting</h4>

		<p>If your host has imposed limits on the size of your database, you may not be able to upgrade to Nova 3. In order to preserve your original data, big portions of the database are duplicated. If you have size limits on your database, please make sure the upgrade will not put your over those limits before you begin.</p>

		<p>We've written an exhaustive <a href="#">upgrade guide</a> that walks you through the process of moving from Nova 2 to 3. Make sure you've read through that document in its entirety before attempting to upgrade your game.</p>

		<p>Last (but certainly not least), make sure you've backed up your Nova files and database before you get started. Files can be backed up by downloading through your FTP client to a folder on your desktop. The database will have to be backed up by exporting the database tables in phpMyAdmin (likely reachable through your cPanel). If you have questions about how to do these things, check with your host.</p>
	</blockquote>

	<div class="row-fluid">
		<div class="span4">
			<a href="#" target="_blank" class="btn btn-block">Nova 2 &rarr; Nova 3 Upgrade Guide</a>
		</div>

		<div class="span4">
			<a href="#" target="_blank" class="btn btn-block">Take a tour of Nova 3</a>
		</div>

		<div class="span4">
			<a href="http://forums.anodyne-productions.com" target="_blank" class="btn btn-block">Anodyne Forums</a>
		</div>
	</div>
@elseif ($option == 3)
	<p>It isn't enough to just release powerful, easy-to-use software, it also needs to maintained. Our goal is to continually make Nova better by fixing issues and adding new functionality. The best way to make sure you're getting the most out of Nova is to keep up with any updates as they're released.</p>

	<blockquote>
		<h4>Before You Begin</h4>

		<p>We <strong>strongly</strong> recommend that you backup both your files and your database. We do our best to test the Nova updates before releasing them, but there is only so much we can test for. In the end, it's better to be safe rather than sorry.</p>
	</blockquote>

	<div class="row-fluid">
		<div class="span4">
			<a href="#" target="_blank" class="btn btn-block">Nova 3 Update Guide</a>
		</div>

		<div class="span4">
			<a href="#" target="_blank" class="btn btn-block">Take a tour of Nova 3</a>
		</div>

		<div class="span4">
			<a href="http://forums.anodyne-productions.com" target="_blank" class="btn btn-block">Anodyne Forums</a>
		</div>
	</div>
	
	<hr>
	
	<h2>{{ $update['version'] }}</h2>
	
	<p>{{ $update['description'] }}</p>
@elseif ($option == 4)
	<div class="row-fluid">
		<div class="span12">
			<h3><span class="icn icn24 text-info" data-icon="u"></span> Update Nova</h3>

			<p>It isn't enough to just build Nova, it needs to be maintained too. Even if your server doesn't allow you to check for updates, you can start the update process from here and be up and running on the latest version of Nova in only a few minutes.</p>

			<a href="{{ URL::to('setup/update') }}" class="btn btn-block">Update Nova</a>
		</div>
	</div>

	<div class="row-fluid">
		<div class="span6">
			<h3><span class="icn icn24 text-warning" data-icon="g"></span> The Genre Panel</h3>

			<p>A flexible genre system allows Nova to be used for a wide range of games. Using the Genre Panel you can change your game's genre to one of the other provided genres. Changing the genre will require some manual work to change your characters to use the proper positions and ranks.</p>

			<a href="{{ URL::to('setup/utilities/genres') }}" class="btn btn-block">The Genre Panel</a>
		</div>

		<div class="span6">
			<h3><span class="icn icn24 text-error" data-icon="-"></span> Uninstall Nova</h3>

			<p>If you want to completely uninstall Nova, you can do so with this option. <strong>Be warned:</strong> this action is permanent and cannot be undone. You will lose all data in the Nova database! Make sure you have backed everything up. Also note that this will not delete any Nova files.</p>

			<a href="{{ URL::to('setup/utilities/uninstall') }}" class="btn btn-block">Uninstall Nova</a>
		</div>
	</div>
@elseif ($option == 5)
	<p>It looks like you're running Nova 1 right now. Unfortunately, there's no way to migrate directly from Nova 1 to Nova 3. In order to get up and running (with most of your Nova 1 data) on Nova 3, you'll need to first update from Nova 1 to Nova 2. Once you're done with that (you don't need to worry about MOD/skin updates) you'll be able to migrate from Nova 2 to Nova 3.</p>

	<div class="row-fluid">
		<div class="span4">
			<a href="#" target="_blank" class="btn btn-block">Nova 1 &rarr; Nova 3 Upgrade Guide</a>
		</div>

		<div class="span4">
			<a href="#" target="_blank" class="btn btn-block">Take a tour of Nova 3</a>
		</div>

		<div class="span4">
			<a href="http://forums.anodyne-productions.com" target="_blank" class="btn btn-block">Anodyne Forums</a>
		</div>
	</div>
@endif