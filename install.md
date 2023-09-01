# Install Nova 3

## Requirements

-   PHP 8.2+
-   MySQL PDO extension
-   MySQL 8.0+
-   Updated, modern browser (Chrome 83+, Brave 1.9+, Safari 13+, Firefox 77+, or Edge 83+)

## Instructions

Ensure you have a separate database for testing Nova 3. Every time a new preview version is made available, you'll need to re-run the install script to destroy the database tables and re-create them.

1. Copy the .env.example file to a new file called .env. (If you don't do this at the start, you'll encounter a bunch of errors)
2. Update the database credentials in .env (indicated by the DB\_ prefix)
3. From the command line, run the following command: php artisan key:generate
4. Navigate to {your-site-url}/setup
