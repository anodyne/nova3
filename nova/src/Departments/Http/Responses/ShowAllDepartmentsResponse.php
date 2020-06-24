<?php

namespace Nova\Departments\Http\Responses;

use Nova\Foundation\Http\Responses\ServerResponse;

class ShowAllDepartmentsResponse extends ServerResponse
{
    public $view = 'departments.index';
}
