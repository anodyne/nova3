<?php

declare(strict_types=1);

uses()->group('posts', 'storytelling');

// A moderated user publishing a post as the only author has their post status set to pending
// A moderated user publishing a post as one of several authors has the post status set to pending
// A non-modereated user publishing a post that includes a moderated user has the past status set to pending
