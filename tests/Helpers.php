<?php

function assertDatabaseHas($table, $data)
{
    test()->assertDatabaseHas($table, $data);

    return test();
}

function assertRouteUsesFormRequest($route, $class)
{
    test()->assertRouteUsesFormRequest($route, $class);

    return test();
}
