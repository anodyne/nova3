<?php

declare(strict_types=1);

return [
    'dashboard' => [
        'On mobile devices, you can add this page to your home screen and get a standalone app that will behave like a native mobile app rather than a normal browser tab.',
        'You can bring up a command palette to quickly move around Nova by using Cmd + K or Cmd + / on Mac. On Windows you can use Ctrl + K or Ctrl + /.',
    ],

    'characters' => [
        "When searching for a character, you can search by the character's name, the name of any of the character's positions, the department name of any of the positions the character is assigned to, or their associated user's name or email address.",
        'Filters and searches from character management respect the tab you currently have selected. If you want to limit your search to inactive characters, you can go the inactive characters tab and then search or filter the list.',
        'The "Assigned to a user" filter will show you both primary and secondary characters.',
        "Primary characters are characters which are assigned to a user and have been marked as a user's primary character.",
        "Secondary characters are characters which are assigned to a user, but are not any user's primary character.",
        "Support characters are characters which are not assigned to any user.",
        'If you want to make a character appear as a primary character, you can assign that character as the primary character of any one of its assigned users.',
        'If you want to make a character appear as a secondary character, you can unassign that character as the primary character of any one of its assigned users.',
        'If you want to make a character appear as a support character, you can unassign all users from the character.',
    ],

    'positions' => [
        'Positions management will show the number of currently active and assigned characters to a specific position.',
        'If a position is marked as inactive, the available slots metric will not show.',
    ],

    'ranks' => [
        'When duplicating a rank group, you can specify a new base image and all the ranks from the original rank group will be duplicated into the new rank group with the new base image.',
        "When creating a rank item, you can quickly create a new rank group or rank name by searching for a rank group or rank name that doesn't exist. You'll be able to create the group or name right from the dropdown.",
    ],

    'roles' => [
        'You can specify as many roles as you want to be assigned to newly created users.',
        'Our recommendation is to create small roles with fewer permissions. This allows you to add sets of permissions to a user by granting them a role instead of trying to put all of the permissions users may need into a single role.'
    ],

    'settings' => [
        'Remember, when you change the default theme for the site, it only applies to the public-facing site and not the admin site.',
    ],

    'users' => [
        'You cannot delete your own account from user management. If you want to delete your account, you can do so from your profile or have another admin delete it for you.',
        'When deactivating a user, all characters associated with the user will also be deactivated.',
        "When searching for a user, you can search by the user's name or email address as well as the name of any of their assigned characters.",
    ],
];
