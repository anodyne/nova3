<?php

declare(strict_types=1);

namespace Nova\Foundation\Responses;

use BadMethodCallException;
use Illuminate\Contracts\Support\Responsable as LaravelResponsable;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Http\Response;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Nova\Foundation\Concerns\SetSEOValues;
use Nova\Menus\Models\Menu;
use Nova\Pages\Models\Page;

abstract class Responsable implements LaravelResponsable
{
    use SetSEOValues;

    public $layout;

    public ?string $subnav = null;

    public $template;

    public string $view;

    protected $app;

    protected array $data = [];

    protected $output;

    protected $page;

    protected $theme;

    public static function send(?Page $page = null, array $seo = []): self
    {
        $instance = new static($page);

        $instance->seoData = $seo;

        return $instance;
    }

    public static function sendWith(array $data, ?Page $page = null, array $seo = []): self
    {
        $instance = new static($page);

        $instance->seoData = $seo;

        return $instance->with($data);
    }

    public function __construct(?Page $page)
    {
        $this->app = app();
        $this->page = $page ?? request()->route()?->findPageFromRoute();
        $this->theme = app('nova.theme');
    }

    public function prepareData(): array
    {
        return app(Pipeline::class)
            ->send(collect($this->data))
            ->through(app('nova.response-filters')->resolveFiltersFor($this->page->key))
            ->then(fn ($data) => $data->all());
    }

    public function layout(): ?string
    {
        if ($this->page->layout === 'public') {
            return 'layouts.theme';
        }

        return null;
    }

    public function subnav(): ?string
    {
        if ($this->subnav) {
            return "subnavs.{$this->subnav}";
        }

        return null;
    }

    public function render(): ViewContract
    {
        $data = array_merge_recursive(
            $this->prepareData(),
            $this->theme->prepareData(),
        );

        $meta = new ResponseMeta(
            layout: $this->layout(),
            subnav: $this->subnav(),
            subnavSection: $this->subnav,
            menu: $this->page->layout === 'public' ? Menu::with('items.page', 'items.items')->public()->first() : null,
            pageHeading: $this->page->heading,
            pageSubheading: $this->page->subheading,
            pageIntro: $this->page->intro,
        );

        app()->instance('nova.meta', $meta);

        View::share('meta', $meta);
        View::share('settings', settings());

        $this->setSEOValues();

        return view("pages.{$this->view}", array_merge($data, [
            'subnav' => $this->subnav,
            'meta' => $meta,
        ]));
    }

    public function toResponse($request): Response
    {
        if ($request->expectsJson()) {
            return response()->json($this->data, Response::HTTP_OK);
        }

        return response($this->render(), Response::HTTP_OK);
    }

    public function with($key, $value = null): self
    {
        if (is_array($key)) {
            $this->data = array_merge($this->data, $key);
        } else {
            $this->data[$key] = $value;
        }

        return $this;
    }

    public function __call($method, $parameters): self
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
}
