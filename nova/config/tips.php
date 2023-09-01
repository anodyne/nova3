<?php

declare(strict_types=1);

return [
    'dashboard' => [
        'On mobile devices, you can add this page to your home screen and get a standalone app that will behave like a native mobile app rather than a normal browser tab.',
        'You can bring up the command palette to quickly move around Nova by using Cmd + K or Cmd + / on Mac. On Windows you can use Ctrl + K or Ctrl + /.',
    ],

    'stories' => [
        'Current stories are stories that are actively running and players can post in.',
        'Ongoing stories are meant for story arcs that are actively running and have postable stories within them.',
        'Upcoming stories are stories that are going to be told in the future.',
        'Completed stories are intended for stories or story arcs that are finished.',
        "Stories live on a timeline that make it easier to visualize and understand the context of the game's world.",
    ],

    'characters' => [
        "When searching for a character, you can search by the character's name, the name of any of the character's positions, the department name of any of the positions the character is assigned to, or their associated user's name or email address.",
        "Primary characters are characters which are assigned to a user and have been marked as a user's primary character.",
        "Secondary characters are characters which are assigned to a user, but are not any user's primary character.",
        'Support characters are characters which are not assigned to any user.',
        'If you want to make a character appear as a primary character, you can assign that character as the primary character of any one of its assigned users.',
        'If you want to make a character appear as a secondary character, you can unassign that character as the primary character of any one of its assigned users.',
        'If you want to make a character appear as a support character, you can unassign all users from the character.',
        'You can group characters in the table by their status or their type for easier viewing.',
        'Users with Create Primary Characters permission will be able to create new primary character(s) for themselves. Admins can choose whether to require approval for created primary characters from Character Settings.',
        'Users with Create Secondary Characters permission will be able to create new secondary character(s) for themselves. Admins can choose whether to require approval for created secondary characters from Character Settings.',
        'Users with Create Support Characters permission will be able to create new support character(s) for the game. Admins can choose whether to require approval for created support characters from Character Settings.',
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
        'Our recommendation is to create small roles with fewer permissions. This allows you to add sets of permissions to a user by granting them a role instead of trying to put all of the permissions users may need into a single role.',
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
