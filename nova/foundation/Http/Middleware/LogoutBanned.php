<?php

declare(strict_types=1);

namespace Nova\Foundation\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Mchev\Banhammer\Exceptions\BanhammerException;
use Symfony\Component\HttpFoundation\Response;

class LogoutBanned
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && $request->user()->isBanned()) {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            throw new BanhammerException(config('ban.messages.user'));
        }

        return $next($request);
    }
}
