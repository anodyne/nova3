<?php

namespace Nova\Foundation;

class Nova
{
    public $version = '3.0.0';

    /**
     * Provide data from the backend for the frontend to use.
     *
     * @return Json
     */
    public function provideScriptVariables()
    {
        return app('nova.data.frontend')->toJson();
    }
}