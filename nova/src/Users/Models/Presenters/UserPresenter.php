<?php

namespace Nova\Users\Models\Presenters;

use Laracasts\Presenter\Presenter;

class UserPresenter extends Presenter
{
    public function lastLogin()
    {
        return optional($this->last_login)->diffForHumans();
    }
}
