<?php

namespace Nova\Posts\Responses;

use Nova\Foundation\Responses\Responsable;

class CreatePostResponse extends Responsable
{
    public $layout = 'app-blank';

    public $view = 'posts.create';
}
