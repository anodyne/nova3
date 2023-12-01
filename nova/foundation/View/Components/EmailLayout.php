<?php

declare(strict_types=1);

namespace Nova\Foundation\View\Components;

use Illuminate\View\Component;

class EmailLayout extends Component
{
    public function render()
    {
        return view('emails.layouts.html.email', [
            'logo' => $this->getBase64EncodedLogo(),
            'gameName' => settings('general.gameName'),
        ]);
    }

    protected function getBase64EncodedLogo(): ?string
    {
        $userUploadedLogo = settings()->getFirstMedia('email-logo');

        return match (filled($userUploadedLogo)) {
            true => base64_encode(file_get_contents($userUploadedLogo->getPath())),
            false => null,
        };
    }
}
