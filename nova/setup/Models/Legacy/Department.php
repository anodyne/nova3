<?php

declare(strict_types=1);

namespace Nova\Setup\Models\Legacy;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    public $timestamps = false;

    protected $connection = 'nova2';

    protected $table = 'departments';

    protected $primaryKey = 'dept_id';
}
