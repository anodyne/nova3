<?php

declare(strict_types=1);

namespace Nova\PublicSite\Actions;

use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;
use Nova\PublicSite\Notifications\SiteContactMessage;
use Nova\Users\Models\User;

class HandleContactForm
{
    use AsAction;

    public function handle(Request $request): void
    {
        $users = User::active()->whereHasPermission('site.contact')->get();

        $users->each->notify(new SiteContactMessage(
            name: $request->input('name'),
            email: $request->input('email'),
            subjectLine: $request->input('subject'),
            message: $request->input('message')
        ));
    }
}
