<?php

function assertDatabaseHas($table, $data)
{
    test()->assertDatabaseHas($table, $data);

    return test();
}
