<?php

namespace Nova\Users;

use Illuminate\Database\Eloquent\Collection;

class UsersCollection extends Collection
{
    /**
     * Get a collection of the theme locations that need to be installed.
     *
     * @return \Illuminate\Support\Collection
     */
    public function pending()
    {
        return collect($this->items);
    }
}
