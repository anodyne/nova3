<?php

namespace Nova\Themes\Http\Controllers;

use Nova\Themes\Jobs;
use Nova\Themes\Events;
use Illuminate\Support\Facades\Storage;
use Nova\Foundation\Http\Controllers\Controller;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Nova\Themes\Exceptions\MissingQuickInstallFileException;
use Nova\Themes\Http\Requests\Install as ValidateInstallingTheme;
use Nova\Themes\Http\Authorizers\Install as AuthorizeInstallingTheme;

class InstallThemeController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke(AuthorizeInstallingTheme $gate, ValidateInstallingTheme $request)
    {
        $themeProperties = $this->getThemePropertiesFromQuickInstallFile($request->theme);

        $theme = dispatch_now(new Jobs\InstallTheme($themeProperties));

        event(new Events\ThemeInstalled($theme));

        return $theme->fresh();
    }

    protected function getThemePropertiesFromQuickInstallFile($location)
    {
        try {
            return json_decode(Storage::disk('themes')->get("{$location}/theme.json"), true);
        } catch (FileNotFoundException $ex) {
            throw new MissingQuickInstallFileException;
        }
    }
}
