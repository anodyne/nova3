<?php

namespace Nova\Themes\Concerns;

use Spatie\Html\Elements\Element;

trait RendersTheme
{
    public $structure;

    public function structure(array $data = []): array
    {
        return [
            'view' => 'app-server',
            'data' => $data,
        ];

        $this->structure = view('app-server', (array) $data);

        return $this;
    }

    public function layout($view, array $data = [])
    {
        $this->structure->layout = view("layouts.{$view}", (array) $data);

        return $this;
    }

    public function template($view, array $data = [])
    {
        $this->structure->layout->template = view("templates.{$view}", (array) $data);

        return $this;
    }

    public function page($view, array $data = [])
    {
        $this->structure->layout->template->content = view("pages.{$view}", (array) $data);

        return $this;
    }

    public function scripts(array $scripts)
    {
        $output = [];

        foreach ($scripts as $script) {
            if (starts_with($script, ['http://', 'https://', '//'])) {
                $path = $script;
            } else {
                $filePath = view()->getFinder()->find("scripts.{$script}");

                // Strip out the base path information
                $path = url(str_replace(base_path(), '', $filePath));
            }

            // Finally, add a script tag
            $output[] = Element::withTag('script')->attribute('src', $path)->render();
        }

        $this->structure->scripts = implode("\r\n", $output);

        return $this;
    }

    public function prepareData(): array
    {
        return [];
    }

    public function __toString()
    {
        try {
            return $this->structure->render();
        } catch (\Exception $exception) {
            dd($exception);
        }
    }
}
