<?php

declare(strict_types=1);

namespace Nova\Foundation\Concerns;

use Nova\Users\Models\User;

trait DelayedConditionalEmail
{
    public function withDelay(User $notifiable): array
    {
        return [
            'mail' => now()->addMinutes(5),
        ];
    }

    public function shouldSend(User $notifiable, string $channel): bool
    {
        if ($channel === 'mail') {
            return ! $notifiable->hasRead($this);
        }

        return true;
    }
}
