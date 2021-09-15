<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Nova NextGen') }}</title>

    @livewireStyles
    @bukStyles
    @novaStyles
    @stack('styles')

    @novaScripts
</head>
<body class="font-sans bg-gray-3 text-gray-12 antialiased {{ auth()->user()?->appearance ?? 'light' }}">
    <div class="relative min-h-screen">
        <header x-data="{ open: false }" class="bg-gray-1 shadow">
            <div class="max-w-7xl mx-auto px-2 sm:px-4 lg:divide-y lg:divide-gray-6 lg:px-8">
                <div class="relative h-16 flex justify-between">
                    <div class="relative z-10 px-2 flex lg:px-0">
                        <div class="flex-shrink-0 flex items-center">
                            <img class="block h-8 w-auto" src="https://tailwindui.com/img/logos/workflow-mark-orange-500.svg" alt="Workflow">
                        </div>
                    </div>

                    <div class="relative z-0 flex-1 px-2 flex items-center justify-center sm:absolute sm:inset-0">
                        <div class="max-w-xs w-full">
                            <label for="search" class="sr-only">Search</label>
                            <div class="relative">
                                <div class="pointer-events-none absolute inset-y-0 left-0 pl-3 flex items-center">
                                    <svg class="flex-shrink-0 h-5 w-5 text-gray-9" x-description="Heroicon name: solid/search" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <input name="search" id="search" class="block w-full bg-gray-1 border border-gray-6 rounded-md py-2 pl-10 pr-3 text-sm placeholder-gray-9 focus:outline-none focus:text-gray-12 focus:placeholder-gray-9 focus:ring-1 focus:ring-gray-12 focus:border-gray-12 sm:text-sm" placeholder="Search" type="search">
                            </div>
                        </div>
                    </div>

                    <div class="relative z-10 flex items-center lg:hidden">
                        <!-- Mobile menu button -->
                        <button type="button" class="rounded-md p-2 inline-flex items-center justify-center text-gray-9 hover:bg-gray-2 hover:text-gray-11 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-gray-12" aria-controls="mobile-menu" @click="open = !open" aria-expanded="false" x-bind:aria-expanded="open.toString()">
                            <span class="sr-only">Open menu</span>

                            <svg x-description="Icon when menu is closed. Heroicon name: outline/menu" x-state:on="Menu open" x-state:off="Menu closed" class="block h-6 w-6" :class="{ 'hidden': open, 'block': !(open) }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>

                            <svg x-description="Icon when menu is open. Heroicon name: outline/x" x-state:on="Menu open" x-state:off="Menu closed" class="hidden h-6 w-6" :class="{ 'block': open, 'hidden': !(open) }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <div class="hidden lg:relative lg:z-10 lg:ml-4 lg:flex lg:items-center">
                        <button type="button" class="flex-shrink-0 bg-gray-1 rounded-full p-1 text-gray-9 hover:text-gray-11 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-12">
                            <span class="sr-only">View notifications</span>
                            <svg class="h-6 w-6" x-description="Heroicon name: outline/bell" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        </button>

                        <!-- Profile dropdown -->
                        <div x-data="Components.menu({ open: false })" x-init="init()" @keydown.escape.stop="open = false; focusButton()" @click.away="onClickAway($event)" class="flex-shrink-0 relative ml-4">
                            <div>
                                <button type="button" class="bg-gray-1 rounded-full flex focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-12" id="user-menu-button" x-ref="button" @click="onButtonClick()" @keyup.space.prevent="onButtonEnter()" @keydown.enter.prevent="onButtonEnter()" aria-expanded="false" aria-haspopup="true" x-bind:aria-expanded="open.toString()" @keydown.arrow-up.prevent="onArrowUp()" @keydown.arrow-down.prevent="onArrowDown()">
                                    <span class="sr-only">Open user menu</span>
                                    <img class="h-8 w-8 rounded-full" src="https://images.unsplash.com/photo-1517365830460-955ce3ccd263?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=facearea&amp;facepad=4&amp;w=256&amp;h=256&amp;q=80" alt="">
                                </button>
                            </div>

                            <div x-show="open" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-gray-1 ring-1 ring-gray-12 ring-opacity-5 py-1 focus:outline-none" x-ref="menu-items" x-description="Dropdown menu, show/hide based on menu state." x-bind:aria-activedescendant="activeDescendant" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1" @keydown.arrow-up.prevent="onArrowUp()" @keydown.arrow-down.prevent="onArrowDown()" @keydown.tab="open = false" @keydown.enter.prevent="open = false; focusButton()" @keyup.space.prevent="open = false; focusButton()" style="display: none;">
                                <a href="#" class="block py-2 px-4 text-sm text-gray-11" x-state:on="Active" x-state:off="Not Active" :class="{ 'bg-gray-2': activeIndex === 0 }" role="menuitem" tabindex="-1" id="user-menu-item-0" @mouseenter="activeIndex = 0" @mouseleave="activeIndex = -1" @click="open = false; focusButton()">Your Profile</a>

                                <a href="#" class="block py-2 px-4 text-sm text-gray-11" :class="{ 'bg-gray-2': activeIndex === 1 }" role="menuitem" tabindex="-1" id="user-menu-item-1" @mouseenter="activeIndex = 1" @mouseleave="activeIndex = -1" @click="open = false; focusButton()">Settings</a>

                                <a href="#" class="block py-2 px-4 text-sm text-gray-11" :class="{ 'bg-gray-2': activeIndex === 2 }" role="menuitem" tabindex="-1" id="user-menu-item-2" @mouseenter="activeIndex = 2" @mouseleave="activeIndex = -1" @click="open = false; focusButton()">Sign out</a>
                            </div>
                        </div>
                    </div>
                </div>

                <nav class="hidden lg:py-2 lg:flex lg:space-x-8" aria-label="Global">
                    <a href="#" class="rounded-md py-2 px-3 inline-flex items-center text-sm font-medium text-gray-12 hover:bg-gray-3 hover:text-gray-12">
                        Dashboard
                    </a>

                    <a href="#" class="rounded-md py-2 px-3 inline-flex items-center text-sm font-medium text-gray-12 hover:bg-gray-3 hover:text-gray-12">
                        Writing
                    </a>

                    <a href="#" class="rounded-md py-2 px-3 inline-flex items-center text-sm font-medium text-gray-12 hover:bg-gray-3 hover:text-gray-12">
                        Characters
                    </a>

                    <a href="#" class="rounded-md py-2 px-3 inline-flex items-center text-sm font-medium text-gray-12 hover:bg-gray-3 hover:text-gray-12">
                        Users
                    </a>

                    <a href="#" class="rounded-md py-2 px-3 inline-flex items-center text-sm font-medium text-gray-12 hover:bg-gray-3 hover:text-gray-12">
                        Settings
                    </a>

                    <a href="#" class="rounded-md py-2 px-3 inline-flex items-center text-sm font-medium text-gray-12 hover:bg-gray-3 hover:text-gray-12">
                        Notes
                    </a>
                </nav>
            </div>

            <nav x-description="Mobile menu, show/hide based on menu state." class="lg:hidden" aria-label="Global" id="mobile-menu" x-show="open" style="display: none;">
                <div class="pt-2 pb-3 px-2 space-y-1">
                    <a href="#" class="block rounded-md py-2 px-3 text-base font-medium text-gray-12 hover:bg-gray-2 hover:text-gray-12">Dashboard</a>

                    <a href="#" class="block rounded-md py-2 px-3 text-base font-medium text-gray-12 hover:bg-gray-2 hover:text-gray-12">Jobs</a>

                    <a href="#" class="block rounded-md py-2 px-3 text-base font-medium text-gray-12 hover:bg-gray-2 hover:text-gray-12">Applicants</a>

                    <a href="#" class="block rounded-md py-2 px-3 text-base font-medium text-gray-12 hover:bg-gray-2 hover:text-gray-12">Company</a>
                </div>

                <div class="border-t border-gray-6 pt-4 pb-3">
                    <div class="px-4 flex items-center">
                        <div class="flex-shrink-0">
                            <img class="h-10 w-10 rounded-full" src="https://images.unsplash.com/photo-1517365830460-955ce3ccd263?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=facearea&amp;facepad=4&amp;w=256&amp;h=256&amp;q=80" alt="">
                        </div>

                        <div class="ml-3">
                            <div class="text-base font-medium text-gray-12">Lisa Marie</div>
                            <div class="text-sm font-medium text-gray-11">lisamarie@example.com</div>
                        </div>

                        <button type="button" class="ml-auto flex-shrink-0 bg-gray-1 rounded-full p-1 text-gray-9 hover:text-gray-11 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-12">
                            <span class="sr-only">View notifications</span>
                            <svg class="h-6 w-6" x-description="Heroicon name: outline/bell" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        </button>
                    </div>

                    <div class="mt-3 px-2 space-y-1">
                        <a href="#" class="block rounded-md py-2 px-3 text-base font-medium text-gray-11 hover:bg-gray-2 hover:text-gray-12">Your Profile</a>

                        <a href="#" class="block rounded-md py-2 px-3 text-base font-medium text-gray-11 hover:bg-gray-2 hover:text-gray-12">Settings</a>

                        <a href="#" class="block rounded-md py-2 px-3 text-base font-medium text-gray-11 hover:bg-gray-2 hover:text-gray-12">Sign out</a>
                    </div>
                </div>
            </nav>
        </header>

        <main class="max-w-7xl mx-auto pb-10 lg:py-12 lg:px-8">
            <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
                <aside class="py-6 px-2 sm:px-6 lg:py-0 lg:px-0 lg:col-span-3">
                    <nav class="space-y-8">
                        <nav class="shadow-nav space-y-1.5">
                            <a href="#" class="text-gray-11 hover:text-gray-12 hover:border-gray-9 border-transparent font-medium group px-3 py-1 flex items-center text-sm border-l-2" x-state:on="Current" x-state:off="Default" x-state-description="Current: &quot;text-blue-11 hover:text-blue-11 border-blue-9 font-semibold&quot;, Default: &quot;text-gray-11 hover:text-gray-12 hover:border-gray-9 border-transparent font-medium&quot;">
                                <span class="truncate">
                                    Profile
                                </span>
                            </a>

                            <a href="#" class="text-gray-11 hover:text-gray-12 hover:border-gray-9 group px-3 py-1 flex items-center text-sm font-medium border-l-2 border-transparent" x-state-description="Current: &quot;text-blue-11 hover:text-blue-11 border-blue-9 font-semibold&quot;, Default: &quot;text-gray-11 hover:text-gray-12 hover:border-gray-9 border-transparent font-medium&quot;">
                                <span class="truncate">
                                    Account
                                </span>
                            </a>

                            <a href="#" class="text-gray-11 hover:text-gray-12 hover:border-gray-9 group px-3 py-1 flex items-center text-sm font-medium border-l-2 border-transparent" x-state-description="Current: &quot;text-blue-11 hover:text-blue-11 border-blue-9 font-semibold&quot;, Default: &quot;text-gray-11 hover:text-gray-12 hover:border-gray-9 border-transparent font-medium&quot;">
                                <span class="truncate">
                                    Password
                                </span>
                            </a>

                            <a href="#" class="text-gray-11 hover:text-gray-12 hover:border-gray-9 group px-3 py-1 flex items-center text-sm font-medium border-l-2 border-transparent" x-state-description="Current: &quot;text-blue-11 hover:text-blue-11 border-blue-9 font-semibold&quot;, Default: &quot;text-gray-11 hover:text-gray-12 hover:border-gray-9 border-transparent font-medium&quot;">
                                <span class="truncate">
                                    Notifications
                                </span>
                            </a>

                            <a href="#" class="text-gray-11 hover:text-gray-12 hover:border-gray-9 border-transparent font-medium group px-3 py-1 flex items-center text-sm border-l-2" aria-current="page" x-state-description="Current: &quot;text-blue-11 hover:text-blue-11 border-blue-9 font-semibold&quot;, Default: &quot;text-gray-11 hover:text-gray-12 hover:border-gray-9 border-transparent font-medium&quot;">
                                <span class="truncate">
                                    Plan &amp; Billing
                                </span>
                            </a>

                            <a href="#" class="text-gray-11 hover:text-gray-12 hover:border-gray-9 group px-3 py-1 flex items-center text-sm font-medium border-l-2 border-transparent" x-state-description="Current: &quot;text-blue-11 hover:text-blue-11 border-blue-9 font-semibold&quot;, Default: &quot;text-gray-11 hover:text-gray-12 hover:border-gray-9 border-transparent font-medium&quot;">
                                <span class="truncate">
                                    Integrations
                                </span>
                            </a>
                        </nav>

                        <nav class="shadow-nav space-y-1.5">
                            <a href="#" class="text-gray-11 hover:text-gray-12 hover:border-gray-9 border-transparent font-medium group px-3 py-1 flex items-center text-sm border-l-2" x-state:on="Current" x-state:off="Default" x-state-description="Current: &quot;text-blue-11 hover:text-blue-11 border-blue-9 font-semibold&quot;, Default: &quot;text-gray-11 hover:text-gray-12 hover:border-gray-9 border-transparent font-medium&quot;">
                                <span class="truncate">
                                    Profile
                                </span>
                            </a>

                            <a href="#" class="text-blue-11 hover:text-blue-11 border-blue-9 font-semibold group px-3 py-1 flex items-center text-sm border-l-2" aria-current="page" x-state-description="Current: &quot;text-blue-11 hover:text-blue-11 border-blue-9 font-semibold&quot;, Default: &quot;text-gray-11 hover:text-gray-12 hover:border-gray-9 border-transparent font-medium&quot;">
                                <span class="truncate">
                                    Plan &amp; Billing
                                </span>
                            </a>
                        </nav>
                    </nav>
                </aside>

                <!-- Payment details -->
                <div class="space-y-6 sm:px-6 lg:px-0 lg:col-span-9">
                    <section aria-labelledby="payment-details-heading">
                        <form action="#" method="POST">
                            <div class="shadow sm:rounded-md sm:overflow-hidden">
                                <div class="bg-gray-1 py-6 px-4 sm:p-6">
                                    <div>
                                        <h2 id="payment-details-heading" class="text-lg leading-6 font-medium text-gray-12">Payment details</h2>
                                        <p class="mt-1 text-sm text-gray-11">Update your billing information. Please note that updating your location could affect your tax rates.</p>
                                    </div>

                                    <div class="mt-6 grid grid-cols-4 gap-6">
                                        <div class="col-span-4 sm:col-span-2">
                                            <label for="first-name" class="block text-sm font-medium text-gray-11">First name</label>
                                            <input type="text" name="first-name" id="first-name" autocomplete="cc-given-name" class="mt-1 block w-full border border-gray-6 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-gray-12 focus:border-gray-12 sm:text-sm">
                                        </div>

                                        <div class="col-span-4 sm:col-span-2">
                                            <label for="last-name" class="block text-sm font-medium text-gray-11">Last name</label>
                                            <input type="text" name="last-name" id="last-name" autocomplete="cc-family-name" class="mt-1 block w-full border border-gray-6 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-gray-12 focus:border-gray-12 sm:text-sm">
                                        </div>

                                        <div class="col-span-4 sm:col-span-2">
                                            <label for="email-address" class="block text-sm font-medium text-gray-11">Email address</label>
                                            <input type="text" name="email-address" id="email-address" autocomplete="email" class="mt-1 block w-full border border-gray-6 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-gray-12 focus:border-gray-12 sm:text-sm">
                                        </div>

                                        <div class="col-span-4 sm:col-span-1">
                                            <label for="expiration-date" class="block text-sm font-medium text-gray-11">Expration date</label>
                                            <input type="text" name="expiration-date" id="expiration-date" autocomplete="cc-exp" class="mt-1 block w-full border border-gray-6 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-gray-12 focus:border-gray-12 sm:text-sm" placeholder="MM / YY">
                                        </div>

                                        <div class="col-span-4 sm:col-span-1">
                                            <label for="security-code" class="flex items-center text-sm font-medium text-gray-11">
                                                <span>Security code</span>
                                                <svg class="ml-1 flex-shrink-0 h-5 w-5 text-gray-300" x-description="Heroicon name: solid/question-mark-circle" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                                                </svg>
                                            </label>
                                            <input type="text" name="security-code" id="security-code" autocomplete="cc-csc" class="mt-1 block w-full border border-gray-6 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-gray-12 focus:border-gray-12 sm:text-sm">
                                        </div>

                                        <div class="col-span-4 sm:col-span-2">
                                            <label for="country" class="block text-sm font-medium text-gray-11">Country / Region</label>
                                            <select id="country" name="country" autocomplete="country" class="mt-1 block w-full bg-gray-1 border border-gray-6 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-gray-12 focus:border-gray-12 sm:text-sm">
                                                <option>United States</option>
                                                <option>Canada</option>
                                                <option>Mexico</option>
                                            </select>
                                        </div>

                                        <div class="col-span-4 sm:col-span-2">
                                            <label for="postal-code" class="block text-sm font-medium text-gray-11">ZIP / Postal</label>
                                            <input type="text" name="postal-code" id="postal-code" autocomplete="postal-code" class="mt-1 block w-full border border-gray-6 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-gray-12 focus:border-gray-12 sm:text-sm">
                                        </div>
                                    </div>
                                </div>
                                <div class="px-4 py-3 bg-gray-2 text-right sm:px-6">
                                    <button type="submit" class="bg-gray-11 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-gray-1 hover:bg-gray-12 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-12">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </form>
                    </section>

                    <!-- Plan -->
                    <section aria-labelledby="plan-heading">
                        <form action="#" method="POST">
                            <div class="shadow sm:rounded-md sm:overflow-hidden">
                                <div class="bg-gray-1 py-6 px-4 space-y-6 sm:p-6">
                                    <div>
                                        <h2 id="plan-heading" class="text-lg leading-6 font-medium text-gray-12">Plan</h2>
                                    </div>

                                    <fieldset x-data="window.Components.radioGroup({ initialCheckedIndex: 1 })" x-init="init()">
                                        <legend class="sr-only">
                                            Pricing plans
                                        </legend>
                                        <div class="relative bg-gray-1 rounded-md -space-y-px">

                                            <label x-radio-group-option="" class="rounded-tl-md rounded-tr-md relative border p-4 flex flex-col cursor-pointer md:pl-4 md:pr-6 md:grid md:grid-cols-3 focus:outline-none border-gray-6" x-description="Checked: &quot;bg-blue-3 border-blue-6 z-10&quot;, Not Checked: &quot;border-gray-6&quot;" :class="{ 'bg-blue-3 border-blue-6 z-10': (value === 'Startup'), 'border-gray-6': !(value === 'Startup') }">
                                                <div class="flex items-center text-sm">
                                                    <input type="radio" x-model="value" name="pricing-plan" value="Startup" class="h-4 w-4 text-blue-7 border-gray-6 focus:ring-gray-12" aria-labelledby="pricing-plans-0-label" aria-describedby="pricing-plans-0-description-0 pricing-plans-0-description-1">
                                                    <span id="pricing-plans-0-label" class="ml-3 font-medium text-gray-12">Startup</span>
                                                </div>
                                                <p id="pricing-plans-0-description-0" class="ml-6 pl-1 text-sm md:ml-0 md:pl-0 md:text-center">
                                                    <span class="font-medium text-gray-12" x-description="Checked: &quot;text-blue-11&quot;, Not Checked: &quot;text-gray-12&quot;" :class="{ 'text-blue-11': (value === 'Startup'), 'text-gray-12': !(value === 'Startup') }">$29 / mo</span>
                                                    <!-- space -->
                                                    <span x-description="Checked: &quot;text-orange-700&quot;, Not Checked: &quot;text-gray-11&quot;" :class="{ 'text-orange-700': (value === 'Startup'), 'text-gray-11': !(value === 'Startup') }" class="text-gray-11">($290 / yr)</span>
                                                </p>
                                                <p id="pricing-plans-0-description-1" class="ml-6 pl-1 text-sm md:ml-0 md:pl-0 md:text-right text-gray-11" x-description="Checked: &quot;text-orange-700&quot;, Not Checked: &quot;text-gray-11&quot;" :class="{ 'text-orange-700': (value === 'Startup'), 'text-gray-11': !(value === 'Startup') }">Up to 5 active job postings</p>
                                            </label>

                                            <label x-radio-group-option="" class="relative border p-4 flex flex-col cursor-pointer md:pl-4 md:pr-6 md:grid md:grid-cols-3 focus:outline-none bg-blue-3 border-blue-6 z-10" x-description="Checked: &quot;bg-blue-3 border-blue-6 z-10&quot;, Not Checked: &quot;border-gray-6&quot;" :class="{ 'bg-blue-3 border-blue-6 z-10': (value === 'Business'), 'border-gray-6': !(value === 'Business') }">
                                                <div class="flex items-center text-sm">
                                                    <input type="radio" x-model="value" name="pricing-plan" value="Business" class="h-4 w-4 text-blue-7 border-gray-6 focus:ring-gray-12" aria-labelledby="pricing-plans-1-label" aria-describedby="pricing-plans-1-description-0 pricing-plans-1-description-1">
                                                    <span id="pricing-plans-1-label" class="ml-3 font-medium text-gray-12">Business</span>
                                                </div>
                                                <p id="pricing-plans-1-description-0" class="ml-6 pl-1 text-sm md:ml-0 md:pl-0 md:text-center">
                                                    <span class="font-medium text-blue-11" x-description="Checked: &quot;text-blue-11&quot;, Not Checked: &quot;text-gray-12&quot;" :class="{ 'text-blue-11': (value === 'Business'), 'text-gray-12': !(value === 'Business') }">$99 / mo</span>
                                                    <!-- space -->
                                                    <span x-description="Checked: &quot;text-orange-700&quot;, Not Checked: &quot;text-gray-11&quot;" :class="{ 'text-orange-700': (value === 'Business'), 'text-gray-11': !(value === 'Business') }" class="text-orange-700">($990 / yr)</span>
                                                </p>
                                                <p id="pricing-plans-1-description-1" class="ml-6 pl-1 text-sm md:ml-0 md:pl-0 md:text-right text-orange-700" x-description="Checked: &quot;text-orange-700&quot;, Not Checked: &quot;text-gray-11&quot;" :class="{ 'text-orange-700': (value === 'Business'), 'text-gray-11': !(value === 'Business') }">Up to 25 active job postings</p>
                                            </label>

                                            <label x-radio-group-option="" class="rounded-bl-md rounded-br-md relative border p-4 flex flex-col cursor-pointer md:pl-4 md:pr-6 md:grid md:grid-cols-3 focus:outline-none border-gray-6" x-description="Checked: &quot;bg-blue-3 border-blue-6 z-10&quot;, Not Checked: &quot;border-gray-6&quot;" :class="{ 'bg-blue-3 border-blue-6 z-10': (value === 'Enterprise'), 'border-gray-6': !(value === 'Enterprise') }">
                                                <div class="flex items-center text-sm">
                                                    <input type="radio" x-model="value" name="pricing-plan" value="Enterprise" class="h-4 w-4 text-blue-7 border-gray-6 focus:ring-gray-12" aria-labelledby="pricing-plans-2-label" aria-describedby="pricing-plans-2-description-0 pricing-plans-2-description-1">
                                                    <span id="pricing-plans-2-label" class="ml-3 font-medium text-gray-12">Enterprise</span>
                                                </div>
                                                <p id="pricing-plans-2-description-0" class="ml-6 pl-1 text-sm md:ml-0 md:pl-0 md:text-center">
                                                    <span class="font-medium text-gray-12" x-description="Checked: &quot;text-blue-11&quot;, Not Checked: &quot;text-gray-12&quot;" :class="{ 'text-blue-11': (value === 'Enterprise'), 'text-gray-12': !(value === 'Enterprise') }">$249 / mo</span>
                                                    <!-- space -->
                                                    <span x-description="Checked: &quot;text-orange-700&quot;, Not Checked: &quot;text-gray-11&quot;" :class="{ 'text-orange-700': (value === 'Enterprise'), 'text-gray-11': !(value === 'Enterprise') }" class="text-gray-11">($2490 / yr)</span>
                                                </p>
                                                <p id="pricing-plans-2-description-1" class="ml-6 pl-1 text-sm md:ml-0 md:pl-0 md:text-right text-gray-11" x-description="Checked: &quot;text-orange-700&quot;, Not Checked: &quot;text-gray-11&quot;" :class="{ 'text-orange-700': (value === 'Enterprise'), 'text-gray-11': !(value === 'Enterprise') }">Unlimited active job postings</p>
                                            </label>

                                        </div>
                                    </fieldset>

                                    <div class="flex items-center" x-data="{ on: true }">
                                        <button type="button" class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-12 transition-colors ease-in-out duration-200 bg-blue-9" role="switch" aria-checked="true" x-ref="switch" x-state:on="Enabled" x-state:off="Not Enabled" :class="{ 'bg-blue-30': on, 'bg-gray-200': !(on) }" aria-labelledby="annual-billing-label" :aria-checked="on.toString()" @click="on = !on">
                                            <span aria-hidden="true" class="inline-block h-5 w-5 rounded-full bg-gray-1 shadow transform ring-0 transition ease-in-out duration-200 translate-x-5" x-state:on="Enabled" x-state:off="Not Enabled" :class="{ 'translate-x-5': on, 'translate-x-0': !(on) }"></span>
                                        </button>
                                        <span class="ml-3" id="annual-billing-label" @click="on = !on; $refs.switch.focus()">
                                            <span class="text-sm font-medium text-gray-12">Annual billing </span>
                                            <span class="text-sm text-gray-11">(Save 10%)</span>
                                        </span>
                                    </div>
                                </div>
                                <div class="px-4 py-3 bg-gray-2 text-right sm:px-6">
                                    <button type="submit" class="bg-gray-11 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-gray-1 hover:bg-gray-12 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-12">
                                        Save
                                    </button>
                                </div>
                            </div>
                        </form>
                    </section>

                    <!-- Billing history -->
                    <section aria-labelledby="billing-history-heading">
                        <div class="bg-gray-1 pt-6 shadow sm:rounded-md sm:overflow-hidden">
                            <div class="px-4 sm:px-6">
                                <h2 id="billing-history-heading" class="text-lg leading-6 font-medium text-gray-12">Billing history</h2>
                            </div>
                            <div class="mt-6 flex flex-col">
                                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                        <div class="overflow-hidden border-t border-gray-6">
                                            <table class="min-w-full divide-y divide-gray-6">
                                                <thead class="bg-gray-2">
                                                    <tr>
                                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-11 uppercase tracking-wider">
                                                            Date
                                                        </th>
                                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-11 uppercase tracking-wider">
                                                            Description
                                                        </th>
                                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-11 uppercase tracking-wider">
                                                            Amount
                                                        </th>
                                                        <!--
                                                            `relative` is added here due to a weird bug in Safari that causes `sr-only` headings to introduce overflow on the body on mobile.
                                                        -->
                                                        <th scope="col" class="relative px-6 py-3 text-left text-xs font-medium text-gray-11 uppercase tracking-wider">
                                                            <span class="sr-only">View receipt</span>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody class="bg-gray-1 divide-y divide-gray-6">

                                                    <tr>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-12">
                                                            <time datetime="2020-01-01">1/1/2020</time>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-11">
                                                            Business Plan - Annual Billing
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-11">
                                                            CA$109.00
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                            <a href="#" class="text-blue-9 hover:text-blue-11">View receipt</a>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-12">
                                                            <time datetime="2019-01-01">1/1/2019</time>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-11">
                                                            Business Plan - Annual Billing
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-11">
                                                            CA$109.00
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                            <a href="#" class="text-blue-9 hover:text-blue-11">View receipt</a>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-12">
                                                            <time datetime="2018-01-01">1/1/2018</time>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-11">
                                                            Business Plan - Annual Billing
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-11">
                                                            CA$109.00
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                            <a href="#" class="text-blue-9 hover:text-blue-11">View receipt</a>
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-12">
                                                            <time datetime="2017-01-01">1/1/2017</time>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-11">
                                                            Business Plan - Annual Billing
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-11">
                                                            CA$109.00
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                            <a href="#" class="text-blue-9 hover:text-blue-11">View receipt</a>
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </main>
    </div>
</body>
</html>