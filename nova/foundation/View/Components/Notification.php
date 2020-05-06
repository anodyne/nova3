<?php

namespace Nova\Foundation\View\Components;

use Illuminate\View\Component;

class Notification extends Component
{
    public $notification;

    public function __construct($notification = null)
    {
        $this->notification = $notification;
    }

    public function render()
    {
        return view('components.notification');
    }
}
