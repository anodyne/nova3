@props(['item'])

@use('Nova\Menus\Enums\LinkType')

@php
    $isActive = $item->link_type === LinkType::Page
        ? request()->routeIs($item->page->key)
        : request()->is($item->url);
@endphp

<li {{ $isActive ? ' data-active' : null }}>
    <x-public::menu.link :item="$item"></x-public::menu.link>
</li>
