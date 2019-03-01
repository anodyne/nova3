<?php

namespace Nova\Themes\Http\Controllers;

use Nova\Themes\Jobs;
use Nova\Themes\Events;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Nova\Foundation\Http\Controllers\Controller;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Nova\Themes\Exceptions\MissingQuickInstallFileException;

class InstallThemeController extends Controller
{
    public function __invoke(Request $request)
    {
        try {
            $themeProperties = json_decode(
                Storage::disk('themes')->get("{$request->theme}/theme.json"),
                true
            );
        } catch (FileNotFoundException $ex) {
            throw new MissingQuickInstallFileException;
        }

        $theme = dispatch_now(new Jobs\InstallThemeJob($themeProperties));

        event(new Events\ThemeInstalled($theme));

        return response()->json($theme, 200);
    }
}