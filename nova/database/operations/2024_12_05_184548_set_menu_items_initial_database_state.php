<?php

declare(strict_types=1);

use Nova\Menus\Enums\LinkType;
use Nova\Menus\Models\Menu;
use Nova\Pages\Models\Page;
use TimoKoerber\LaravelOneTimeOperations\OneTimeOperation;

return new class extends OneTimeOperation
{
    protected bool $async = false;

    protected string $queue = 'default';

    protected ?string $tag = null;

    public function process(): void
    {
        activity()->disableLogging();

        $menu = Menu::create(['name' => 'Public', 'key' => 'public']);

        $menu->items()->createMany([
            ['label' => 'Home', 'link_type' => LinkType::Page, 'page_id' => Page::key('home')->first()->id],
            ['label' => 'Characters', 'link_type' => LinkType::Page, 'page_id' => Page::key('public.characters')->first()->id],
            ['label' => 'Stories', 'link_type' => LinkType::Page, 'page_id' => Page::key('public.stories')->first()->id],
            ['label' => 'Join', 'link_type' => LinkType::Page, 'page_id' => Page::key('public.join')->first()->id],
            ['label' => 'Contact', 'link_type' => LinkType::Page, 'page_id' => Page::key('public.contact')->first()->id],
        ]);

        activity()->enableLogging();
    }
};
