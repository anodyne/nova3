<?php

declare(strict_types=1);

namespace Nova\Themes\Controllers;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Storage;
use Nova\Foundation\Controllers\Controller;
use Nova\Themes\Actions\CreateTheme;
use Nova\Themes\DataTransferObjects\ThemeData;
use Nova\Themes\Events\ThemeInstalled;
use Nova\Themes\Exceptions\MissingQuickInstallFileException;
use Nova\Themes\Models\Theme;
use Nova\Themes\Requests\InstallThemeRequest;

class InstallThemeController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->middleware('auth');
    }

    public function __invoke(InstallThemeRequest $request, CreateTheme $action)
    {
        $this->authorize('create', Theme::class);

        $theme = $action->execute(
            new ThemeData($this->getThemePropertiesFromQuickInstallFile($request->theme))
        );

        ThemeInstalled::dispatch($theme);

        return redirect()
            ->route('themes.index')
            ->withToast("{$theme->name} was installed");
    }

    protected function getThemePropertiesFromQuickInstallFile($location)
    {
        try {
            return json_decode(Storage::disk('themes')->get("{$location}/theme.json"), true);
        } catch (FileNotFoundException $ex) {
            throw new MissingQuickInstallFileException();
        }
    }
}
