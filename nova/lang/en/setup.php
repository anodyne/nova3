<?php

return [

	'config' => [
		'exists' => "The :0 file already exists in the <code>app/config/:1</code> directory. If you need to change any of the items in this file, you can either manually edit the file or delete it and start over again.",
		'noconfig' => "The :0 file template located at <code>nova/src/Nova/Setup/generators/:1</code> couldn't be found. Please upload the file from the Nova zip archive and try again.",
		'php' => "Your server is running PHP version :0 but Nova requires at least PHP 5.4.0. You cannot continue with the setup process. Please contact your host about correcting this issue.",

		'db' => [
			'nodb' => "The PDO extension or drivers couldn't be found and must be present in order to continue with Nova's setup. Contact your host to resolve this issue.",
			'connection' => "Enter your database connection details below. If you're not sure about these, contact your web host.",
			'intro' => "Before installing Nova 3, we need to establish a connection to the database. In order to do that, you'll need to have the following information about your database:</p><ol><li>The name of the database</li><li>Your database username</li><li>Your database password</li><li>The database host</li></ol><p>In all likelihood, your web host gave you this information when you created your account. If you don't have this information, contact your web host and they'll be able to get you what you need in order to continue.</p><blockquote><p>If for any reason Nova can't automatically create the database config file for you, you'll be able to do so manually. If you'd prefer to do this process manually, you can open <code>nova/src/Nova/Setup/generators/database.php</code>, copy its contents and paste them into a new file called <code>database.php</code> in the <code>app/config/:0</code> directory.</p></blockquote>",
			'check' => [
				'success'=> "A successful connection was made to your database. Please continue to attempt creating the config file with the connection parameters specified.",
				'nohost' => "The database host you provided could not be found. Most of the time, web hosts use <code>localhost</code>, but in some instances, they set up their servers differently. Check with your web host about the proper database host to use and try again.",
				'userpass' => "The username and/or password you provided doesn't seem to work. Double check your username and/or password and try again.",
				'dbname' => "A successful connection was made to your database server (which means your username and password are fine) but the database <code>:0</code> couldn't be found.</p><ul><li>Are you sure it exists?</li><li>Does the user have permission to use the <code>:0</code> database?</li><li>On some systems the name of your database is prefixed with your username, like <code>username_:0</code>. Could that be the problem?</li></ul><p>If you don't know how to setup a database or your database connection settings, you should contact your web host.",
				'gen' => "There was an unidentified error when trying to connect to the database. This could be caused by incorrect database connection settings or the database server being down. Check with your web host to see if there are any issues and try again."
			],
			'write' => [
				'success' => "Database connection config file was successfully created. You can now continue with the Nova setup.",
				'failure' => "Uh-oh! I couldn't write the database connection file. This is probably because your server doesn't allow creating and writing to files. Don't worry though, you can copy the text below and paste it into a new file called <code>db.php</code> in the <code>app/config/:0</code> directory. Once you've saved and uploaded the file, you can re-test your database connection.",
			],
		],

		'email' => [
			'intro' => "Like previous versions of Nova, email is a critical component to keep players updated on new content, private messages and many other things. Unlike previous versions though, we no longer recommend using PHP's built-in <code>mail()</code> function (this is how email has been sent in all previous versions of Nova). In order to provide greater reliability delivering emails to players, you should use an SMTP email service. You can read more about emails in Nova and your options for setting this up in the <a href='#' target='_blank'>email options</a> document in AnodyneDocs. It's still possible to use PHP's <code>mail()</code> function, but we don't recommend it.</p><p>Before setting up Nova 3, the email config file needs to be created. In order to do that, you'll need to have some of the following information about how you want to send email from Nova:</p><ol><li>Whether you want to use SMTP, sendmail or PHP's <code>mail()</code> function</li><li>The name of the SMTP server you're using</li><li>The server port</li><li>The encryption type</li><li>Your SMTP server username</li><li>Your SMTP server password</li><li>The path to sendmail</li></ol><p>If you've chosen to use PHP's <code>mail()</code> function, you won't need anything, but if you've elected to use SMTP email or sendmail, then in all likelihood, your web host or SMTP host (if you're using a third-party service) gave you this information when you created your account. If you don't have this information, contact your web host/SMTP host and they'll be able to get you what you need in order to continue.</p><blockquote><p>If for any reason Nova can't automatically create the email config file for you, you'll be able to do so manually. If you'd prefer to do this process manually, you can open <code>nova/src/Nova/Setup/generators/mail.php</code>, copy its contents and paste them into a new file called <code>mail.php</code> in the <code>app/config/:0</code> directory.</p></blockquote>",
			'info' => "The information below can be found from either your web host or your SMTP service host. You can read more about emails in Nova and your options for setting this up in the <a href='#' target='_blank'>email options</a> document in AnodyneDocs.",
			'write' => [
				'success' => "The email config file was successfully created. You can now continue with the Nova setup.",
				'failure' => "The email config file couldn't be created. This is probably because your server doesn't allow creating and/or writing to files. Don't worry though, you can copy the text below and paste it into a new file called <code>mail.php</code> in the <code>app/config/:0</code> directory. Once you've saved and uploaded the file, you can verify the settings and continue setting up Nova.",
			],
			'verify' => [
				'success' => "The email config file has been verified. You can now continue setting up Nova.",
				'failure' => "The email config file still couldn't be found. Either the file wasn't properly created or you haven't manually created the file yet. You can start the wizard over to attempt to create the file again.",
			],
		],
	],

];