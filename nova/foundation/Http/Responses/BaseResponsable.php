<?php

namespace Nova\Foundation\Http\Responses;

use Nova\Pages\Page;
use BadMethodCallException;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Contracts\Foundation\Application;

abstract class BaseResponsable implements Responsable
{
    /**
     * The application instance.
     *
     * @var  \Nova\Foundation\Application
     */
    protected $app;

    /**
     * The array of response data.
     *
     * @var  array
     */
    protected $data = [];

    /**
     * The final output of the response.
     *
     * @var  string
     */
    protected $output;

    /**
     * The page instance for the response.
     *
     * @var  \Nova\Pages\Page
     */
    protected $page;

    /**
     * The theme instance for the response.
     *
     * @var  \Nova\Themes\BaseTheme
     */
    protected $theme;

    public function __construct(Page $page, Application $app)
    {
        $this->app = $app;
        $this->page = $page;
        $this->theme = $app['nova.theme'];
    }

    /**
     * Get the array of response data.
     *
     * @param  string  $key
     * @param  string  $default
     *
     * @return array
     */
    public function getData($key = null, $default = null)
    {
        if ($key === null) {
            return $this->data;
        }

        return data_get($this->data, $key, $default);
    }

    /**
     * Get the name of the current route from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return string
     */
    public function getRouteName(Request $request)
    {
        return $request->route()->getName();
    }

    /**
     * Get a specific view name.
     *
     * @param  string  $view
     *
     * @return string
     */
    public function getView($view)
    {
        $views = array_merge([
            'structure' => 'master',
            'layout' => [
                'view' => $this->theme->getPageLayout($this->page),
                'data' => 'data',
                // 'view' => 'app-sidebar',
                // 'data' => $this->theme->getPageLayoutData($this->page)
            ],
            // 'template' => $this->page->content_template,
            'page' => $this->page,
            'script' => null,
            'component' => null,
        ], $this->views() ?? []);

        return data_get($views, $view, null);
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

    public function structure()
    {
        return 'app-server';
    }

    public function layout()
    {
        return "layouts.{$this->theme->getPageLayout($this->page)}";
    }

    public function template()
    {
        return 'templates.simple';
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

        $this->buildStructure()
            ->buildLayout()
            ->buildTemplate()
            ->buildPage();
        // ->buildScripts();

        return $this->output;
    }

    /**
     * Handle converting this to a response object that Laravel knows what
     * to do with.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    abstract public function toResponse($request);

    /**
     * The list of views for the response.
     *
     * @return array
     */
    public function views()
    {
        return [];
    }

    /**
     * Any data that should be sent with the response.
     *
     * @param  array  $data
     * @param mixed $key
     * @param null|mixed $value
     *
     * @return \Nova\Foundation\Http\Responses\BaseResponsable
     */
    public function with($key, $value = null)
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
     *
     * @return \Nova\Foundation\Http\Responses\BaseResponsable
     *
     */
    public function __call($method, $parameters)
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

    /**
     * Build the layout.
     *
     * @return \Nova\Foundation\Http\Responses\BaseResponsable
     */
    protected function buildLayout()
    {
        $this->output = $this->theme->layout($this->getView('layout.view'));

        return $this;
    }

    /**
     * Build the page.
     *
     * @return \Nova\Foundation\Http\Responses\BaseResponsable
     */
    protected function buildPage()
    {
        $this->output = $this->theme->page($this->getView('page'), $this->data);

        return $this;
    }

    /**
     * Build the scripts.
     *
     * @return \Nova\Foundation\Http\Responses\BaseResponsable
     */
    protected function buildScripts()
    {
        $this->output = $this->theme->scripts((array) $this->getView('script'));

        return $this;
    }

    /**
     * Build the structure.
     *
     * @return \Nova\Foundation\Http\Responses\BaseResponsable
     */
    protected function buildStructure()
    {
        $this->output = $this->theme->structure();

        return $this;
    }

    /**
     * Build the content template.
     *
     * @return \Nova\Foundation\Http\Responses\BaseResponsable
     */
    protected function buildTemplate()
    {
        $this->output = $this->theme->template('simple');

        return $this;
    }

    /**
     * Pass the final data off to the container for use in the views.
     *
     * @return \Nova\Foundation\Http\Responses\BaseResponsable
     */
    protected function passDataToContainer()
    {
        $this->app->extend('nova.data.response', function ($app) {
            return $this->data;
        });

        return $this;
    }
}
