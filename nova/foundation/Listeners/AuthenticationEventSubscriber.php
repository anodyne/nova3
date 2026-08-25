<?php

declare(strict_types=1);

namespace Nova\Foundation\Listeners;

use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\PasswordResetLinkSent;
use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use Nova\Users\Models\User;

class AuthenticationEventSubscriber
{
    public function handleLogin(Login $event): void
    {
        if (! $event->user instanceof User) {
            return;
        }

        $this->info($event, "User {$event->user->email} logged in", array_merge(
            $event->user->only('id', 'email'),
            ['ip' => Request::ip()]
        ));
    }

    public function handleLoginFailed(Failed $event): void
    {
        $this->info($event, "User {$event->credentials['email']} attempted login failed", [
            'email' => $event->credentials['email'],
            'ip' => Request::ip(),
        ]);
    }

    public function handleLogout(Logout $event): void
    {
        if (! $event->user instanceof User) {
            return;
        }

        $this->info($event, "User {$event->user->email} logged out", array_merge(
            $event->user->only('id', 'email'),
            ['ip' => Request::ip()]
        ));
    }

    public function handlePasswordReset(PasswordReset $event): void
    {
        if (! $event->user instanceof User) {
            return;
        }

        $this->info($event, "User {$event->user->email} reset their password", array_merge(
            $event->user->only('id', 'email'),
            ['ip' => Request::ip()]
        ));
    }

    public function handlePasswordResetLinkSent(PasswordResetLinkSent $event): void
    {
        if (! $event->user instanceof User) {
            return;
        }

        $this->info($event, "User {$event->user->email} requested a password reset link", array_merge(
            $event->user->only('id', 'email'),
            ['ip' => Request::ip()]
        ));
    }

    /** @return array<class-string, string> */
    public function subscribe(Dispatcher $dispatcher): array
    {
        return [
            Failed::class => 'handleLoginFailed',
            Login::class => 'handleLogin',
            Logout::class => 'handleLogout',
            PasswordReset::class => 'handlePasswordReset',
            PasswordResetLinkSent::class => 'handlePasswordResetLinkSent',
        ];
    }

    /** @param array<string, mixed> $context */
    protected function info(object $event, string $message, array $context = []): void
    {
        $class = class_basename($event::class);

        Log::info("[{$class}] {$message}", $context);
    }
}
