<?php

declare(strict_types=1);

namespace Nova\Foundation\View\Layouts;

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
        $userUploadedLogo = settings()?->getFirstMedia('logo-email');

        if ($userUploadedLogo === null) {
            return null;
        }

        $contents = file_get_contents($userUploadedLogo->getPath());

        return $contents === false ? null : base64_encode($contents);
    }
}
