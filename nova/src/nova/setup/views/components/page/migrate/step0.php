<p>Like previous versions of Nova, Nova 3 is a dynamic, database-driven web system which means, you guessed it, I need to install the Nova-specific database pieces now and then migrate most of your Nova data to the newer Nova 3 format. Start to finish, the upgrade should only take a few minutes to complete (probably about 10 minutes depending on your Internet connection) and then you'll be on your way.</p>

<div class="alert alert-info">
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