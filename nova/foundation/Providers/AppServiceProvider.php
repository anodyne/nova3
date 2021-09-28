<?php

declare(strict_types=1);

namespace Nova\Foundation\Providers;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Illuminate\View\Factory as ViewFactory;
use Livewire\Livewire;
use Nova\Foundation\Icons\FeatherIconSet;
use Nova\Foundation\Icons\FluentIconSet;
use Nova\Foundation\Icons\FontAwesomeSolidIconSet;
use Nova\Foundation\Icons\IconSets;
use Nova\Foundation\Icons\StreamlineUiIconSet;
use Nova\Foundation\Livewire\IconsSelectMenu;
use Nova\Foundation\Livewire\UploadAvatar;
use Nova\Foundation\Livewire\UploadImage;
use Nova\Foundation\Macros;
use Nova\Foundation\NovaBladeDirectives;
use Nova\Foundation\NovaManager;
use Nova\Foundation\View\Components\Avatar;
use Nova\Foundation\View\Components\AvatarGroup;
use Nova\Foundation\View\Components\Badge;
use Nova\Foundation\View\Components\Button;
use Nova\Foundation\View\Components\Dropdown;
use Nova\Foundation\View\Components\Link;
use Nova\Foundation\View\Components\Tips;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->registerNovaSingleton();
    }

    public function boot()
    {
        // Make sure the file finder can find Javascript files
        $this->app['view']->addExtension('js', 'file');

        $this->registerMacros();
        $this->registerIcons();
        $this->registerBladeDirectives();
        $this->registerBladeComponents();
        $this->registerLivewireComponents();
        $this->setupFactories();
    }

    protected function registerNovaSingleton()
    {
        $this->app->singleton('nova', NovaManager::class);
    }

    protected function registerMacros()
    {
        RedirectResponse::mixin(new Macros\RedirectResponseMacros());
        Route::mixin(new Macros\RouteMacros());
        Str::mixin(new Macros\StrMacros());
        ViewFactory::mixin(new Macros\ViewMacros());
    }

    protected function registerIcons()
    {
        $iconSets = new IconSets();
        $iconSets->add('fluent', new FluentIconSet());
        $iconSets->add('feather', new FeatherIconSet());
        $iconSets->add('fas', new FontAwesomeSolidIconSet());
        $iconSets->add('sui', new StreamlineUiIconSet());

        $this->app->instance(IconSets::class, $iconSets);
    }

    protected function registerBladeComponents()
    {
        Blade::component('avatar', Avatar::class);
        Blade::component('avatar-group', AvatarGroup::class);
        Blade::component('badge', Badge::class);
        Blade::component('button', Button::class);
        Blade::component('link', Link::class);
        Blade::component('dropdown', Dropdown::class);
        Blade::component('tips', Tips::class);
    }

    protected function registerBladeDirectives()
    {
        Blade::directive('icon', [NovaBladeDirectives::class, 'icon']);
        Blade::directive('novaScripts', [NovaBladeDirectives::class, 'novaScripts']);
        Blade::directive('novaStyles', [NovaBladeDirectives::class, 'novaStyles']);
    }

    protected function registerLivewireComponents()
    {
        Livewire::component('icons-select-menu', IconsSelectMenu::class);
        Livewire::component('upload-avatar', UploadAvatar::class);
        Livewire::component('upload-image', UploadImage::class);
    }

    protected function setupFactories()
    {
        Factory::guessFactoryNamesUsing(
            fn ($model) => 'Database\\Factories\\'.Str::afterLast($model, '\\').'Factory'
        );
    }
}
