<?php

namespace Nova\Themes\Actions;

use Illuminate\Http\Request;
use Nova\Themes\DataTransferObjects\ThemeData;
use Nova\Themes\Models\Theme;

class CreateThemeManager
{
    protected $createTheme;

    protected $setupThemeDirectory;

    public function __construct(
        CreateTheme $createTheme,
        SetupThemeDirectory $setupThemeDirectory
    ) {
        $this->createTheme = $createTheme;
        $this->setupThemeDirectory = $setupThemeDirectory;
    }

    public function execute(Request $request): Theme
    {
        $theme = $this->createTheme->execute(
            $data = ThemeData::fromRequest($request)
        );

        $this->setupThemeDirectory->execute($data);

        return $theme;
    }
}
