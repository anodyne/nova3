# Notable Changes

## Logging In

- All users are "remembered" when logging in. If you're on a public computer, make sure you explicitly log out when you're done using Nova.
- Resetting passwords has been changed to a 2-step process. The first step involves entering your email address. From there, an email is sent to you with a confirmation code. Going to that link will prompt you to change your password. If at any point you get prompted to reset a password without you initiating it, you can simply log in to your account to cancel the reset process.
- Logging in is immediate. No more sitting on a "Logging In" screen for 5 seconds before being pushed to the admin control panel.
- When you try to hit a page that requires authentication and you aren't logged in, you'll be prompted to log in and then bounced to the page you were trying to get to once you've successfully authenticated.

## Setup

- We no longer provide the ability to upgrade from SMS.
- We no longer provide the ability to upgrade from Nova 1.
- The database change panel has been removed. Instead of this, developers should be writing migrations to install (and uninstall) their MODs through the module catalog.
- We no longer require entering a password at various spots throughout the Setup Center. Instead, you must be logged in and be an administrator in order to make changes once the system is installed. If you aren't, you'll be kicked over to the log in page. Once you've been logged in, you'll be redirected back to the Setup Center.

## Admin Control Panel

- All of Nova's routes are managed through the new Routes Manager. This allows admins to completely change where Nova pulls its resources for a URI from.

## Access Control

- Every access role is now made up of tasks instead of pages. Using tasks allows more granular control. For example, when dealing with forms, users can be given permissions to just edit forms, but not create or delete them.
- Access roles can now inherit their tasks from other roles. When inherited roles are updated, those changes cascade to any roles that inherit from that specific role.
- If a role has been updated, the next time any user lands on the Nova site, their permissions will automatically be updated.

## Dynamic Forms

- All dynamic forms are managed from the same place now.
- All dynamic forms can include tabs and sections instead of just select forms.
- Form fields can be "locked down" based on access role to prevent certain people from making changes to data.
- Brand new form field value management user interface.
- Drag-and-drop support for reordering tabs, sections, fields and field values.
- Smarter field type management.
- All-new FormViewer lets you create forms and have users fill out a form without having to manually embed the form into a new page. You can also view, update and delete records for a form from FormViewer as well. (Protected forms, such as the forms that come with Nova, cannot use FormViewer.)
- When using FormViewer, you can opt to send the results of a submitted form to a set of email addresses.

## Ranks

## Resource Catalogs

- Previously, the defaults for new users (both skins and ranks) were set from the catalog, but the defaults for the site were set from Site Settings. This created a lot of confusion. In Nova 3, everything comes off of Site Settings. If you set your default skin in Site Settings, then every new user after you change that will have that as their default.
- Because of the new skinning architecture, we've been able to eliminate the idea of "skin sections" from the catalogs completely. This greatly simplifies how the skin catalog is built and managed.
- Admins can now delete active skins and ranks. A dropdown will be displayed and they'll be able to change everyone (including Site Settings) who has the skin/rank being deleted.

## User Management

- Users can be created from the management page. In previous versions of Nova, users could only be created through the join form.
- Users can only be deleted if they don't have content associated with them. Content that will prevent a user from being deleted are: announcements, personal logs, posts, received awards and application reviews. If a user has content associated with them, their status will be set to REMOVED instead of being deleted altogether.
- By default, only active users are shown in User Management. The thinking here is that, generally, you will only be managing active users. If you need to do something with an inactive user, you can use the new search feature to find other users.
- A new "live search" feature lets you find users by their name, email address or any character associated with their account.