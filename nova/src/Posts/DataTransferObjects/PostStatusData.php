<?php

namespace Nova\Posts\DataTransferObjects;

use Spatie\DataTransferObject\DataTransferObject;

class PostStatusData extends DataTransferObject
{
    public string $status;
}