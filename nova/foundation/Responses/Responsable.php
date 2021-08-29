<?php

declare(strict_types=1);

namespace Nova\Foundation\Responses;

use BadMethodCallException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Responsable as LaravelResponsable;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Nova\Pages\Page;

abstract class Responsable implements LaravelResponsable
{
    public $layout;

    public $template;

    public string $view;

    protected $app;

    protected $data = [];

    protected $output;

    protected $page;

    protected $theme;

    public function __construct(Page $page, Application $app)
    {
        $this->app = $app;
        $this->page = $page;
        $this->theme = $app['nova.theme'];
    }

    /**
     * Handle preparing the data to be used by the view.
     *
     * This is a method that's meant to be used in the individual Responsable
     * objects, especially by developers that want to make some changes to
     * the data before Nova takes over again and uses that data.
     *
     * @return array
     */
    public function prepareData(): array
    {
        return $this->data;
    }

    public function layout(): string
    {
        $layout = $this->layout ?? $this->theme->getPageLayout($this->page);

        return "layouts.{$layout}";
    }

    public function template(): string
    {
        $template = $this->template ?? 'simple';

        return "templates.{$template}";
    }

    /**
     * Render the response.
     *
     * @return string
     */
    public function render()
    {
        $data = array_merge_recursive(
            $this->prepareData(),
            $this->theme->prepareData(),
        );

        return view("pages.{$this->view}", array_merge([
            '__novaStructure' => 'app',
            '__novaLayout' => $this->layout(),
            '__novaTemplate' => $this->template(),
        ], $data));
    }

    public function toResponse($request)
    {
        if ($request->expectsJson()) {
            return response()->json($this->data, Response::HTTP_OK);
        }

        return response($this->render(), Response::HTTP_OK);
    }

    /**
     * Any data that should be sent with the response.
     *
     * @param  array  $data
     * @param mixed $key
     * @param null|mixed $value
     */
    public function with($key, $value = null): self
    {
        if (is_array($key)) {
            $this->data = array_merge($this->data, $key);
        } else {
            $this->data[$key] = $value;
        }

        return $this;
    }

    /**
     * Dynamically bind parameters to the response.
     *
     * @param  string  $method
     * @param  array   $parameters
     *
     * @throws \BadMethodCallException
     */
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
