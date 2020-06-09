Ensure you have a separate database for testing Nova 3. Every time a new preview version is made available, you'll need to go through this process which will destroy the database tables and re-create them.

1. Copy the .env.example file to a new file called .env. (If you don't do this at the start, you'll encounter a bunch of errors)
2. Update the database credentials in .env (indicated by the DB_ prefix)
3. From the command line, run the following command: php artisan key:generate
4. Navigate to {your-site-url}/setup