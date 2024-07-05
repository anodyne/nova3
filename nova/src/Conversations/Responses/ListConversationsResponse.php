<?php

declare(strict_types=1);

namespace Nova\Conversations\Responses;

use Nova\Foundation\Responses\Responsable;

class ListConversationsResponse extends Responsable
{
    public string $view = 'conversations.index';
}
