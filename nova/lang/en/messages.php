<?php

declare(strict_types=1);

return [

    'change-post-type' => 'Are you sure you want to change your post’s type from **:old** to **:new**? This may potentially impact the post’s data and authors. Ensure that you are verifying all information before publishing the post.',

    'discard-post-draft' => 'Are you sure you want to discard this :type draft? You will not be able to recover it and will need to start a new post in order to continue writing.',

    'delete-post' => 'Are you sure you want to delete this post? This action is permanent and you will not be able to recover it.',

    'post-validation-errors' => 'To save your :type, please add a **:fields**',

    'table' => [
        'bulk-delete-failure' => ':success of :total :label deleted',
        'bulk-delete-success' => ':count selected :label has been deleted|:count selected :label have been deleted',
        'bulk-delete-total-failure' => 'Failed to delete any :label',

        'delete-failure' => ':title :label could not be deleted',
        'delete-success' => ':title :label was deleted',

        'replicate-failure' => ':title :label could not be duplicated',
        'replicate-success' => ':title :label was duplicated',
    ],

];
