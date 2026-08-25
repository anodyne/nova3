<?php

declare(strict_types=1);

namespace Nova\Foundation\Responses;

use BadMethodCallException;
use Illuminate\Contracts\Support\Responsable as LaravelResponsable;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Nova\Foundation\Concerns\SetSEOValues;
use Nova\Foundation\Enums\CacheKeys;
use Nova\Menus\Actions\RecacheMenus;
use Nova\Menus\Models\Menu;
use Nova\Pages\Models\Page;
use Nova\Themes\BaseTheme;

abstract class Responsable implements LaravelResponsable
{
    use SetSEOValues;

    public ?string $layout = null;

    public ?string $subnav = null;

    public ?string $template = null;

    public string $view;

    /** @var array<string, mixed> */
    protected array $data = [];

    protected mixed $output = null;

    protected ?Page $page;

    protected ?BaseTheme $theme;

    final public function __construct(?Page $page)
    {
        $this->page = $page ?? request()->route()?->findPageFromRoute();
        $this->theme = app('nova.theme');
    }

    /** @param list<mixed> $parameters */
    public function __call(string $method, array $parameters): self
    {
        if (! Str::startsWith($method, 'with')) {
            throw new BadMethodCallException(sprintf(
                'Method %s::%s does not exist.',
                static::class,
                $method
            ));
        }

        return $this->with(Str::camel(substr($method, 4)), $parameters[0]);
    }

    public function layout(): ?string
    {
        if ($this->page?->layout === 'public') {
            return 'layouts.theme';
        }

        return null;
    }

    /** @return array<string, mixed> */
    public function prepareData(): array
    {
        return app(Pipeline::class)
            ->send(collect($this->data))
            ->through(app('nova.response-filters')->resolveFiltersFor($this->page?->key))
            ->then(fn ($data) => $data->all());
    }

    public function render(): ViewContract
    {
        $data = array_merge_recursive(
            $this->prepareData(),
            $this->theme->prepareData(),
        );

        $responseMeta = new ResponseMeta(
            layout: $this->layout(),
            subnav: $this->subnav(),
            subnavSection: $this->subnav,
            menu: $this->page?->layout === 'public' ? $this->getPublicMenuItems() : null,
            pageHeading: $this->page?->heading,
            pageSubheading: $this->page?->subheading,
            pageIntro: $this->page?->intro,
        );

        app()->instance('nova.meta', $responseMeta);

        View::share('meta', $responseMeta);
        View::share('settings', settings());

        $this->setSEOValues();

        return View::make("pages.{$this->view}", array_merge($data, [
            'subnav' => $this->subnav,
            'meta' => $responseMeta,
        ]));
    }

    public function subnav(): ?string
    {
        if ($this->subnav) {
            return "subnavs.{$this->subnav}";
        }

        return null;
    }

    /** @param Request $request */
    public function toResponse($request): Response|JsonResponse
    {
        if ($request->expectsJson()) {
            return response()->json($this->data, Response::HTTP_OK);
        }

        return response($this->render(), Response::HTTP_OK);
    }

    /** @param string|array<string, mixed> $key */
    public function with(string|array $key, mixed $value = null): self
    {
        if (is_array($key)) {
            $this->data = array_merge($this->data, $key);
        } else {
            $this->data[$key] = $value;
        }

        return $this;
    }

    /** @param array<string, mixed> $seo */
    public static function send(?Page $page = null, array $seo = []): self
    {
        $static = new static($page);

        $static->seoData = $seo;

        return $static;
    }

    /**
     * @param  array<string, mixed>  $data
     * @param  array<string, mixed>  $seo
     */
    public static function sendWith(array $data, ?Page $page = null, array $seo = []): self
    {
        $static = new static($page);

        $static->seoData = $seo;

        return $static->with($data);
    }

    protected function getPublicMenuItems(): Menu
    {
        RecacheMenus::run();

        return Cache::get(CacheKeys::BasicMenu->value);
    }
}
