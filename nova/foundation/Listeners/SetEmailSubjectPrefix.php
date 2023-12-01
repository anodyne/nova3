<?php

declare(strict_types=1);

namespace Nova\Foundation\Listeners;

use Illuminate\Mail\Events\MessageSending;

class SetEmailSubjectPrefix
{
    public function handle(MessageSending $event)
    {
        $message = $event->message;

        $message->subject(trim(settings('email.subjectPrefix')).' '.$message->getSubject());
    }
}
