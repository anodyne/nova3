# Notable Changes since Nova 2

## Logging In

- All users are "remembered" when logging in. If you're on a public computer, make sure you explicitly log out when you're done using Nova.

## Setup

- We no longer provide the ability to upgrade from SMS.
- We no longer provide the ability to upgrade from Nova 1.
- The database change panel has been removed. Instead of this, developers should be writing migrations to install (and uninstall) their MODs. More information is available in the Dev Center.
- We no longer require entering a password at various spots throughout the Setup Center. Instead, you must be logged in and be an administrator in order to make changes once the system is installed. If you aren't, you'll be kicked over to the log in page.

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

## Ranks