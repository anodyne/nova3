<?php

declare(strict_types=1);

namespace Nova\Users\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Mchev\Banhammer\Models\Ban as BaseBan;

class Ban extends BaseBan
{
    use HasFactory;
}
