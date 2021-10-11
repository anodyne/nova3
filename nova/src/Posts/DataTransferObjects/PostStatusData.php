<?php

declare(strict_types=1);

namespace Nova\Posts\DataTransferObjects;

use Spatie\DataTransferObject\DataTransferObject;

class PostStatusData extends DataTransferObject
{
    public string $status;
}
