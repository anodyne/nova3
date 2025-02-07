<?php

declare(strict_types=1);

return [

    'impersonated' => ':description (Impersonated by **:user**)',

    'addons' => [
        'ran-script' => '**:name** ran the :script script for the add-on.',
    ],

    'applications' => [
        'message-added' => '**:name** added a message on the application discussion.',
        'reviewers-added' => '**:name** added **:reviewers** as a reviewer on the application.|**:name** added **:reviewers** as reviewers on the application.',
        'reviewers-removed' => '**:name** removed **:reviewers** as a reviewer on the application.|**:name** removed **:reviewers** as reviewers on the application.',
        'vote-accept' => '**:name** voted to accept the application.',
        'vote-deny' => '**:name** voted to deny the application.',
    ],

    'characters' => [
        'removed-avatar' => '**:name** removed the avatar for the character.',
        'uploaded-avatar' => '**:name** uploaded an avatar for the character.',
    ],

    'departments' => [
        'duplicated' => '**:name** duplicated the department as **:replica**.',
        'uploaded' => '**:name** uploaded a department header image.',
    ],

    'forms' => [
        'duplicated' => '**:name** duplicated the form as **:replica**.',
    ],

    'notes' => [
        'duplicated' => '**:name** duplicated the note as **:replica**.',
    ],

    'positions' => [
        'duplicated' => '**:name** duplicated the position as **:replica**.',
    ],

    'ranks' => [
        'group-duplicated' => '**:name** duplicated the rank group to the new group **:rankGroup**.',
        'name-duplicated' => '**:name** duplicated the rank name to the new name **:rankName**.',
    ],

];
