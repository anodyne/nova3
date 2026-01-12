<?php

declare(strict_types=1);

namespace Database\Factories;

use Database\Factories\Concerns\CanHandleDataForRequests;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Str;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Pages\Enums\PageVerb;
use Nova\Pages\Models\Page;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Nova\Model>
 */
class PageFactory extends Factory
{
    use CanHandleDataForRequests;

    protected $model = Page::class;

    public function definition(): array
    {
        $name = $this->faker->words(3, asText: true);

        return [
            'name' => $name,
            'uri' => $this->faker->url,
            'key' => Str::slug($name),
            'verb' => PageVerb::Get,
            'layout' => 'admin',
            'status' => BasicStatus::Active,
        ];
    }

    public function active(): Factory
    {
        return $this->state([
            'status' => BasicStatus::Active,
        ]);
    }

    public function advanced(): Factory
    {
        return $this->state([
            'resource' => 'Nova\Test\Controllers\TestController@index',
        ]);
    }

    public function basic(): Factory
    {
        return $this->state([
            'resource' => null,
        ]);
    }

    public function inactive(): Factory
    {
        return $this->state([
            'status' => BasicStatus::Inactive,
        ]);
    }

    public function published(array $blocks = []): Factory
    {
        return $this->state([
            'published_at' => Date::now(),
            'published_blocks' => $blocks,
        ]);
    }

    public function verbDelete(): Factory
    {
        return $this->state([
            'verb' => PageVerb::Delete,
        ]);
    }

    public function verbGet(): Factory
    {
        return $this->state([
            'verb' => PageVerb::Get,
        ]);
    }

    public function verbPost(): Factory
    {
        return $this->state([
            'verb' => PageVerb::Post,
        ]);
    }

    public function verbPut(): Factory
    {
        return $this->state([
            'verb' => PageVerb::Put,
        ]);
    }
}
