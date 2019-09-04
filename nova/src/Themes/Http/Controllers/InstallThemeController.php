<?php

namespace Nova\Themes\Http\Controllers;

use Nova\Themes\Models\Theme;
use Nova\Themes\Jobs\InstallTheme;
use Nova\Themes\Events\ThemeInstalled;
use Nova\Themes\Http\Requests\Install;
use Illuminate\Support\Facades\Storage;
use Nova\Foundation\Http\Controllers\Controller;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Nova\Themes\Exceptions\MissingQuickInstallFileException;

class InstallThemeController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke(Install $request)
    {
        $this->authorize('create', Theme::class);

        $theme = InstallTheme::dispatchNow(
            $this->getThemePropertiesFromQuickInstallFile($request->theme)
        );

        event(new ThemeInstalled($theme));

        return $theme->refresh();
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
