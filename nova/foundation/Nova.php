<?php

namespace Nova\Foundation;

class Nova
{
    public $version = '3.0.0';

    /**
     * Provide data from the backend for the frontend to use.
     *
     * @return array
     */
    public function provideScriptVariables()
    {
        return [
            'icons' => app('nova.theme')->iconMap(),
            'system' => [
                'version' => $this->version
            ],
            'theme' => app('nova.theme'),
        ];
    }
}