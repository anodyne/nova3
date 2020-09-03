<?php

namespace Nova\Posts\Responses;

use Nova\Foundation\Responses\Responsable;

class PickPostTypeResponse extends Responsable
{
    public $layout = 'app-writing';

    public $view = 'posts.pick-post-type';
}
