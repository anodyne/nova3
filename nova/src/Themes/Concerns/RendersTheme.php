<?php

declare(strict_types=1);

namespace Nova\Themes\Concerns;

use Exception;
use Illuminate\Support\Facades\View;
use Spatie\Html\Elements\Element;

trait RendersTheme
{
    public mixed $structure;

    public function __toString(): string
    {
        try {
            return $this->structure->render();
        } catch (Exception $exception) {
            dd($exception);
        }
    }

    /** @param array<string, mixed> $data */
    public function layout(string $view, array $data = []): static
    {
        $this->structure->layout = View::make("layouts.{$view}", $data);

        return $this;
    }

    /** @param array<string, mixed> $data */
    public function page(string $view, array $data = []): static
    {
        $this->structure->layout->template->content = View::make("pages.{$view}", $data);

        return $this;
    }

    /** @return array<string, mixed> */
    public function prepareData(): array
    {
        return [];
    }

    /** @param list<string> $scripts */
    public function scripts(array $scripts): static
    {
        $output = collect();

        foreach ($scripts as $script) {
            if (str($script)->startsWith(['http://', 'https://', '//'])) {
                $path = $script;
            } else {
                $filePath = view()->getFinder()->find("scripts.{$script}");

                // Strip out the base path information
                $path = url(str_replace(base_path(), '', $filePath));
            }

            // Finally, add a script tag
            $output->push(Element::withTag('script')->attribute('src', $path)->render());
        }

        $this->structure->scripts = $output->join("\r\n");

        return $this;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array{view: string, data: array<string, mixed>}
     */
    public function structure(array $data = []): array
    {
        return [
            'view' => 'app-server',
            'data' => $data,
        ];
    }

    /** @param array<string, mixed> $data */
    public function template(string $view, array $data = []): static
    {
        $this->structure->layout->template = View::make("templates.{$view}", $data);

        return $this;
    }
}
