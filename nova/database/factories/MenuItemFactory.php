<?php

declare(strict_types=1);

namespace Database\Factories;

use Database\Factories\Concerns\CanHandleDataForRequests;
use Illuminate\Database\Eloquent\Factories\Factory;
use Nova\Foundation\Enums\BasicStatus;
use Nova\Menus\Enums\LinkTarget;
use Nova\Menus\Enums\LinkType;
use Nova\Menus\Models\Menu;
use Nova\Menus\Models\MenuItem;

/** @extends Factory<MenuItem> */
class MenuItemFactory extends Factory
{
    use CanHandleDataForRequests;

    protected $model = MenuItem::class;

    public function active(): static
    {
        return $this->state([
            'status' => BasicStatus::Active,
        ]);
    }

    public function definition(): array
    {
        return [
            'label' => $this->faker->word(),
            'link_type' => LinkType::Url,
            'url' => $this->faker->url(),
            'page_id' => null,
            'menu_id' => fn (): string => Menu::public()->value('id'),
            'status' => BasicStatus::Active,
            'target' => $this->faker->randomElement(LinkTarget::cases()),
            'parent_id' => null,
        ];
    }

    public function inactive(): static
    {
        return $this->state([
            'status' => BasicStatus::Inactive,
        ]);
    }
}
