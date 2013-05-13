# Notable Changes since Nova 2

## Logging In

- All users are "remembered" when logging in. If you're on a public computer, make sure you log out when you're done.

## Setup

- We no longer provide the ability to upgrade from SMS.
- We no longer provide the ability to upgrade from Nova 1.
- The database change panel has been removed. Instead of this, developers should be writing migrations to install (and uninstall) their MODs. More information is available in the Dev Center.
- We no longer require entering a password at various spots throughout the Setup Center. Instead, you must be logged in and be an administrator in order to make changes once the system is installed. If you aren't, you'll be kicked over to the log in page.