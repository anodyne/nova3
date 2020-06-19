<?php

if (! function_exists('create')) {
    function create($class, array $attributes = [], array $states = [])
    {
        $factory = factory($class);

        if (count($states) > 0) {
            $factory->states($states);
        }

        return $factory->create($attributes);
    }
}

if (! function_exists('make')) {
    function make($class, array $attributes = [], array $states = [])
    {
        $factory = factory($class);

        if (count($states) > 0) {
            $factory->states($states);
        }

        return $factory->make($attributes);
    }
}
