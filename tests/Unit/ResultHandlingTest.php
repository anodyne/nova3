<?php

declare(strict_types=1);

use Illuminate\Filesystem\FilesystemManager;
use Nova\Addons\Actions\SetupAddonDirectory;
use Nova\Themes\Actions\SetupThemeDirectory;
use Nova\Users\Data\UserPostingReport;

it('reads scaffold stubs as strings', function () {
    $addonAction = new class extends SetupAddonDirectory
    {
        public function stub(string $file): string
        {
            return $this->readStub($file);
        }
    };
    $themeAction = new class(app(FilesystemManager::class)) extends SetupThemeDirectory
    {
        public function stub(string $file): string
        {
            return $this->readStub($file);
        }
    };

    expect($addonAction->stub('addon.json.stub'))->toContain('DummyName')
        ->and($themeAction->stub('theme.json.stub'))->toContain('DummyName');
});

it('rejects an unreadable scaffold stub', function () {
    $action = new class extends SetupAddonDirectory
    {
        public function stub(string $file): string
        {
            return $this->readStub($file);
        }
    };

    expect(fn (): string => $action->stub('missing.stub'))
        ->toThrow(RuntimeException::class, 'Unable to read add-on stub');
});

it('always formats posting totals as strings', function () {
    $report = new UserPostingReport(posts: 1200, words: 3456);

    expect($report->formattedPosts())->toBeString()->toContain('1', '200')
        ->and($report->formattedWords())->toBeString()->toContain('3', '456');
});
