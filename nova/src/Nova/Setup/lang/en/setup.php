<?php

return array(
	'config' => array(
		'exists' => "The :type file already exists in the <code>app/config/:env</code> directory. If you need to change any of the items in this file, you can either manually edit the file or delete it and start over again.",
		'noconfig' => "The :type file template located at <code>nova/src/Nova/Setup/generators/:file</code> couldn't be found. Please upload the file from the Nova zip archive and try again.",
		'php' => "Your server is running PHP version :php but Nova requires at least PHP 5.3.7. You cannot continue with the setup process. Please contact your host about correcting this issue.",

		'db' => array(
			'nodb' => "The PDO extension or drivers couldn't be found and must be present in order to continue with Nova's setup. Contact your host to resolve this issue.",
			'connection' => "Enter your database connection details below. If you're not sure about these, contact your web host.",
			'intro' => "Before installing Nova 3, the database connection file needs to be created. In order to do that, you'll need to have the following information about your database:</p><ol><li>The database name</li><li>The database username</li><li>The database password</li><li>The database host</li><li>The table prefix you want to use</li></ol><p>In all likelihood, your web host gave you this information when you created your account. If you don't have this information, contact your web host and they'll be able to get you what you need in order to continue.</p><blockquote><p>If for any reason this wizard can't automatically create the database connection file for you you, don't worry. All the wizard does is fill in the database information to a config file for you. You can also open <code>nova/src/Nova/Setup/generators/database.php</code>, copy its contents and paste them into a new file called <code>database.php</code> in the <code>app/config/:env</code> directory if you'd rather not use this wizard.</p></blockquote>",
			'check' => array(
				'success'=> "A successful connection was made to your database. Please continue to attempt creating the config file with the connection parameters specified.",
				'nohost' => "The database host you provided could not be found. Most of the time, web hosts use <code>localhost</code>, but in some instances, they set up their servers differently. Check with your web host about the proper database host to use and try again.",
				'userpass' => "The username and/or password you provided doesn't seem to work. Double check your username and/or password and try again.",
				'dbname' => "A successful connection was made to your database server (which means your username and password are fine) but the database <code>:dbname</code> couldn't be found.</p><ul><li>Are you sure it exists?</li><li>Does the user have permission to use the <code>:dbname</code> database?</li><li>On some systems the name of your database is prefixed with your username, like <strong>username_:dbname</strong>. Could that be the problem?</li></ul><p>If you don't know how to setup a database or your database connection settings, you should <strong>contact your web host</strong>.",
				'gen' => "There was an unidentified error when trying to connect to the database. This could be caused by incorrect database connection settings or the database server being down. Check with your web host to see if there are any issues and try again."
			),
			'write' => array(
				'success' => "Database connection config file was successfully created. You can now continue with the Nova setup.",
				'failure' => "Uh-oh! I couldn't write the database connection file. This is probably because your server doesn't allow creating and writing to files. Don't worry though, you can copy the text below and paste it into a new file called <code>db.php</code> in the <code>app/config/:env</code> directory. Once you've saved and uploaded the file, you can re-test your database connection.",
			),
		),

		'email' => array(
			'intro' => "Nova 3 requires an SMTP server for sending emails. This has been done for several reasons, but the main reason is to provide greater reliability delivering emails to players. You can read more about emails in Nova and your options for setting this up in the <a href='#' target='_blank'>email options</a> document in AnodyneDocs.</p><p>Before setting up Nova 3, the email config file needs to be created. In order to do that, you'll need to have the following information about how you want to send email from Nova:</p><ol><li>The name of the SMTP server you're using</li><li>The server port</li><li>The encryption type</li><li>The email address and name you want emails to come from</li><li>Your SMTP server username</li><li>Your SMTP server password</li></ol><p>In all likelihood, your web host or SMTP host (if you're using a third-party service) gave you this information when you created your account. If you don't have this information, contact your web host/SMTP host and they'll be able to get you what you need in order to continue.</p><blockquote><p>If for any reason this wizard can't automatically create the email config file for you you, don't worry. All the wizard does is fill in the information to a config file for you. You can also open <code>nova/src/Nova/Setup/generators/mail.php</code>, copy its contents and paste them into a new file called <code>mail.php</code> in the <code>app/config/:env</code> directory if you'd rather not use this wizard.</p></blockquote>",
			'info' => "The information below can be found from either your web host or your SMTP service host. You can read more about emails in Nova and your options for setting this up in the <a href='#' target='_blank'>email options</a> document in AnodyneDocs.",
			'write' => array(
				'success' => "The email config file was successfully created. You can now continue with the Nova setup.",
				'failure' => "The email config file couldn't be created. This is probably because your server doesn't allow creating and/or writing to files. Don't worry though, you can copy the text below and paste it into a new file called <code>mail.php</code> in the <code>app/config/:env</code> directory. Once you've saved and uploaded the file, you can verify the settings and continue setting up Nova.",
			),
			'verify' => array(
				'success' => "The email config file has been verified. You can now continue setting up Nova.",
				'failure' => "The email config file still couldn't be found. Either the file wasn't properly created or you haven't manually created the file yet. You can start the wizard over to attempt to create the file again.",
			),
		),
	),
	
	'error' => array(
		'1' => "The system is already installed. If you want to re-install the system, you must first remove all the system data and database tables.",
		'2' => "You must be a system administrator to change this RPG's genre!",
		'no_genre' => "Uh-oh! I wasn't able to find a genre code in your Nova config file. This can happen if you have created your own genre file, have edited the Nova config file, or you experienced some file corruption with the download. To fix this, open the Nova config file located at <code>app/config/nova.php</code> and add the genre code before trying again.",
		'not_logged_in' => "Oops! You aren't logged in and can't see the install options until you :login.",
		'install_tables_exist' => "Uh oh! Looks like you've opted to do a fresh install, but you've got a previous version of Nova in this database with the same database table prefix (<code>:prefix</code>). Before you can continue, you'll need to change your database table prefix in the <nobr><code>app/config/production/db.php</code></nobr> file.",
	),
	
	'install' => array(
		'step1' => array(
			'success' => "You're pretty good at this! The database tables have been created and some basic data put in to them. Now, just fill out the information below and I'll update the system with it.",
			'failure' => "Uh oh! I ran in to a problem trying creating the database and put some basic data in the tables. For starters, make sure all your settings are right and try again. If you still can't install the system, drop us a line at our <a href='http://forums.anodyne-productions.com' target='_blank'>forums</a> for more help.",
		),
	),

	'uninstall' => array(
		'instructions' => "Whoa, hold up! Uninstalling Nova will remove all the data in the database tables (posts, logs, characters, etc.) as well as any MODs you've installed and cannot be undone. <strong>Make absolutely sure you want to do this before continuing.</strong>",
		'success' => "Poof! I was able to successfully uninstall Nova 3. Now, you can go back to the Setup Center to re-install Nova 3 or upgrade from Nova 2.",
		'failure' => "Uh oh! I wasn't able to uninstall Nova 3. Try again or if the problem continues, you can manually remove the database tables from the database.",
		'no_tables' => "I couldn't find a Nova 3 installation to remove.",
	),

	'change' => array(
		'default' => "You can use the sections below to modify your database for any changes you'd like to make. You can only add tables and fields, you cannot delete or modify existing tables or fields. In addition, you can only take these actions on Nova's tables, no other tables in your database.</p><p class='alert alert-danger'>Use extreme caution when modifying the database!",
		'query' => "I can run any properly formatted MySQL query you have (like something that may have come with a MOD). Simply paste the query into the field below and I'll execute the query.</p><p class='alert alert-danger'><strong>Warning:</strong> MySQL queries can cause a lot of damage to your Nova database so make sure you trust whoever gave you the query and understand what the query is trying to do!",
		'field' => "Need a new field in one of the Nova database tables? I can create a new field for you, all you need to do is tell me a little about the field you want to create.",
		'table' => "Need a new database table for a MOD or something cool you're working on? I can create a new database table for you, all you need to do is tell me what you want to call the table. Don't worry about adding the table prefix, I'll do that before creating the table as well as an ID field for you. If you want to change the ID field, you'll have to do that from inside the database.",
	),
);
