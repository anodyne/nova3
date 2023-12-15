<?php

declare(strict_types=1);

namespace Nova\Foundation\Listeners;

use Illuminate\Mail\Events\MessageSending;

class SetEmailSubjectPrefix
{
    public function handle(MessageSending $event)
    {
        $message = $event->message;

        $subject = [];

        if (filled($prefix = settings('email.subjectPrefix'))) {
            $subject[] = trim($prefix);
        }

        $subject[] = $message->getSubject();

        $message->subject(implode(' ', $subject));
    }
}
