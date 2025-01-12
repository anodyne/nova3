@use('Illuminate\Support\Number')
@use('Nova\Settings\Enums\PostingTimeframe')

<x-admin-layout>
    <x-page-header></x-page-header>

    <!-- xs to lg -->
    <div class="mx-auto mt-12 max-w-md space-y-8 sm:mt-16 lg:hidden">
        <section class="p-8">
            <h3 id="tier-starter" class="text-sm/6 font-semibold text-gray-900">December 2024</h3>
            <p class="mt-2 flex items-baseline gap-x-1 text-gray-900">
                <span class="text-4xl font-semibold">$19</span>
                <span class="text-sm font-semibold">/month</span>
            </p>
            <a
                href="#"
                aria-describedby="tier-starter"
                class="mt-8 block rounded-md px-3 py-2 text-center text-sm/6 font-semibold text-primary-600 ring-1 ring-inset ring-primary-200 hover:ring-primary-300 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600"
            >
                Buy plan
            </a>
            <ul role="list" class="mt-10 space-y-4 text-sm/6 text-gray-900">
                <li>
                    <ul role="list" class="space-y-4">
                        <li class="flex gap-x-3">
                            <svg
                                class="h-6 w-5 flex-none text-primary-600"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                                aria-hidden="true"
                                data-slot="icon"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            <span>Edge content delivery</span>
                        </li>
                        <li class="flex gap-x-3">
                            <svg
                                class="h-6 w-5 flex-none text-primary-600"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                                aria-hidden="true"
                                data-slot="icon"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            <span>
                                Custom domains
                                <span class="text-sm/6 text-gray-500">(1)</span>
                            </span>
                        </li>
                        <li class="flex gap-x-3">
                            <svg
                                class="h-6 w-5 flex-none text-primary-600"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                                aria-hidden="true"
                                data-slot="icon"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            <span>
                                Team members
                                <span class="text-sm/6 text-gray-500">(3)</span>
                            </span>
                        </li>
                    </ul>
                </li>
                <li>
                    <ul role="list" class="space-y-4">
                        <li class="flex gap-x-3">
                            <svg
                                class="h-6 w-5 flex-none text-primary-600"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                                aria-hidden="true"
                                data-slot="icon"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            <span>Advanced analytics</span>
                        </li>
                    </ul>
                </li>
                <li>
                    <ul role="list" class="space-y-4">
                        <li class="flex gap-x-3">
                            <svg
                                class="h-6 w-5 flex-none text-primary-600"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                                aria-hidden="true"
                                data-slot="icon"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            <span>24/7 online support</span>
                        </li>
                    </ul>
                </li>
            </ul>
        </section>

        <section class="rounded-xl bg-gray-400/5 p-8 ring-1 ring-inset ring-gray-200">
            <h3 id="tier-growth" class="text-sm/6 font-semibold text-gray-900">January 2025</h3>
            <p class="mt-2 flex items-baseline gap-x-1 text-gray-900">
                <span class="text-4xl font-semibold">$49</span>
                <span class="text-sm font-semibold">/month</span>
            </p>
            <a
                href="#"
                aria-describedby="tier-growth"
                class="mt-8 block rounded-md bg-primary-600 px-3 py-2 text-center text-sm/6 font-semibold text-white hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600"
            >
                Buy plan
            </a>
            <ul role="list" class="mt-10 space-y-4 text-sm/6 text-gray-900">
                <li>
                    <ul role="list" class="space-y-4">
                        <li class="flex gap-x-3">
                            <svg
                                class="h-6 w-5 flex-none text-primary-600"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                                aria-hidden="true"
                                data-slot="icon"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            <span>Edge content delivery</span>
                        </li>
                        <li class="flex gap-x-3">
                            <svg
                                class="h-6 w-5 flex-none text-primary-600"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                                aria-hidden="true"
                                data-slot="icon"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            <span>
                                Custom domains
                                <span class="text-sm/6 text-gray-500">(3)</span>
                            </span>
                        </li>
                        <li class="flex gap-x-3">
                            <svg
                                class="h-6 w-5 flex-none text-primary-600"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                                aria-hidden="true"
                                data-slot="icon"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            <span>
                                Team members
                                <span class="text-sm/6 text-gray-500">(20)</span>
                            </span>
                        </li>
                    </ul>
                </li>
                <li>
                    <ul role="list" class="space-y-4">
                        <li class="flex gap-x-3">
                            <svg
                                class="h-6 w-5 flex-none text-primary-600"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                                aria-hidden="true"
                                data-slot="icon"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            <span>Advanced analytics</span>
                        </li>
                        <li class="flex gap-x-3">
                            <svg
                                class="h-6 w-5 flex-none text-primary-600"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                                aria-hidden="true"
                                data-slot="icon"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            <span>Basic reports</span>
                        </li>
                    </ul>
                </li>
                <li>
                    <ul role="list" class="space-y-4">
                        <li class="flex gap-x-3">
                            <svg
                                class="h-6 w-5 flex-none text-primary-600"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                                aria-hidden="true"
                                data-slot="icon"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            <span>24/7 online support</span>
                        </li>
                        <li class="flex gap-x-3">
                            <svg
                                class="h-6 w-5 flex-none text-primary-600"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                                aria-hidden="true"
                                data-slot="icon"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            <span>Quarterly workshops</span>
                        </li>
                    </ul>
                </li>
            </ul>
        </section>

        <section class="p-8">
            <h3 id="tier-scale" class="text-sm/6 font-semibold text-gray-900">Lifetime</h3>
            <p class="mt-2 flex items-baseline gap-x-1 text-gray-900">
                <span class="text-4xl font-semibold">$99</span>
                <span class="text-sm font-semibold">/month</span>
            </p>
            <a
                href="#"
                aria-describedby="tier-scale"
                class="mt-8 block rounded-md px-3 py-2 text-center text-sm/6 font-semibold text-primary-600 ring-1 ring-inset ring-primary-200 hover:ring-primary-300 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600"
            >
                Buy plan
            </a>
            <ul role="list" class="mt-10 space-y-4 text-sm/6 text-gray-900">
                <li>
                    <ul role="list" class="space-y-4">
                        <li class="flex gap-x-3">
                            <svg
                                class="h-6 w-5 flex-none text-primary-600"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                                aria-hidden="true"
                                data-slot="icon"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            <span>Edge content delivery</span>
                        </li>
                        <li class="flex gap-x-3">
                            <svg
                                class="h-6 w-5 flex-none text-primary-600"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                                aria-hidden="true"
                                data-slot="icon"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            <span>
                                Custom domains
                                <span class="text-sm/6 text-gray-500">(Unlimited)</span>
                            </span>
                        </li>
                        <li class="flex gap-x-3">
                            <svg
                                class="h-6 w-5 flex-none text-primary-600"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                                aria-hidden="true"
                                data-slot="icon"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            <span>
                                Team members
                                <span class="text-sm/6 text-gray-500">(Unlimited)</span>
                            </span>
                        </li>
                        <li class="flex gap-x-3">
                            <svg
                                class="h-6 w-5 flex-none text-primary-600"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                                aria-hidden="true"
                                data-slot="icon"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            <span>Single sign-on (SSO)</span>
                        </li>
                    </ul>
                </li>
                <li>
                    <ul role="list" class="space-y-4">
                        <li class="flex gap-x-3">
                            <svg
                                class="h-6 w-5 flex-none text-primary-600"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                                aria-hidden="true"
                                data-slot="icon"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            <span>Advanced analytics</span>
                        </li>
                        <li class="flex gap-x-3">
                            <svg
                                class="h-6 w-5 flex-none text-primary-600"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                                aria-hidden="true"
                                data-slot="icon"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            <span>Basic reports</span>
                        </li>
                        <li class="flex gap-x-3">
                            <svg
                                class="h-6 w-5 flex-none text-primary-600"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                                aria-hidden="true"
                                data-slot="icon"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            <span>Professional reports</span>
                        </li>
                        <li class="flex gap-x-3">
                            <svg
                                class="h-6 w-5 flex-none text-primary-600"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                                aria-hidden="true"
                                data-slot="icon"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            <span>Custom report builder</span>
                        </li>
                    </ul>
                </li>
                <li>
                    <ul role="list" class="space-y-4">
                        <li class="flex gap-x-3">
                            <svg
                                class="h-6 w-5 flex-none text-primary-600"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                                aria-hidden="true"
                                data-slot="icon"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            <span>24/7 online support</span>
                        </li>
                        <li class="flex gap-x-3">
                            <svg
                                class="h-6 w-5 flex-none text-primary-600"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                                aria-hidden="true"
                                data-slot="icon"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            <span>Quarterly workshops</span>
                        </li>
                        <li class="flex gap-x-3">
                            <svg
                                class="h-6 w-5 flex-none text-primary-600"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                                aria-hidden="true"
                                data-slot="icon"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            <span>Priority phone support</span>
                        </li>
                        <li class="flex gap-x-3">
                            <svg
                                class="h-6 w-5 flex-none text-primary-600"
                                viewBox="0 0 20 20"
                                fill="currentColor"
                                aria-hidden="true"
                                data-slot="icon"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M16.704 4.153a.75.75 0 0 1 .143 1.052l-8 10.5a.75.75 0 0 1-1.127.075l-4.5-4.5a.75.75 0 0 1 1.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 0 1 1.05-.143Z"
                                    clip-rule="evenodd"
                                />
                            </svg>
                            <span>1:1 onboarding tour</span>
                        </li>
                    </ul>
                </li>
            </ul>
        </section>
    </div>

    <!-- lg+ -->
    <div class="isolate mt-20 hidden lg:block">
        <div class="relative -mx-8">
            @if ($settings->isMonthlyTimeframe())
                <div class="absolute inset-x-4 inset-y-0 -z-10 flex">
                    <div class="flex w-1/4 px-4" style="margin-left: 50%" aria-hidden="true">
                        <div class="w-full rounded-t-xl border-x border-t border-gray-900/10 bg-gray-400/5"></div>
                    </div>
                </div>
            @else
                <div class="absolute inset-x-4 inset-y-0 -z-10 flex">
                    <div class="flex w-1/5 px-4" style="margin-left: 40%" aria-hidden="true">
                        <div class="w-full rounded-t-xl border-x border-t border-gray-900/10 bg-gray-400/5"></div>
                    </div>
                </div>
                <div class="absolute inset-x-4 inset-y-0 -z-10 flex">
                    <div class="flex w-1/5 px-4" style="margin-left: 80%" aria-hidden="true">
                        <div class="w-full rounded-t-xl border-x border-t border-gray-900/10 bg-gray-400/5"></div>
                    </div>
                </div>
            @endif

            <table class="w-full table-fixed border-separate border-spacing-x-8 text-left">
                <caption class="sr-only">Pricing plan comparison</caption>
                <colgroup>
                    <col class="w-1/5" />
                    <col class="w-1/5" />
                    <col class="w-1/5" />
                    <col class="w-1/5" />
                    @unless ($settings->isMonthlyTimeframe())
                        <col class="w-1/5" />
                    @endunless
                </colgroup>
                <thead>
                    <tr>
                        <td></td>
                        @unless ($settings->isMonthlyTimeframe())
                            <th scope="col" class="px-6 pt-6 xl:px-8 xl:pt-8">
                                <div class="text-center text-base/8 font-semibold text-gray-900">
                                    {{ $settings->timeframe->getStatsLabel() }}
                                </div>
                            </th>
                        @endunless

                        <th scope="col" class="px-6 pt-6 xl:px-8 xl:pt-8">
                            <div class="text-center text-base/8 font-semibold text-gray-900">
                                {{ now()->subMonth()->format('F Y') }}
                            </div>
                        </th>
                        <th scope="col" class="px-6 pt-6 xl:px-8 xl:pt-8">
                            <div class="text-center text-base/8 font-semibold text-gray-900">
                                {{ now()->format('F Y') }}
                            </div>
                        </th>
                        <th scope="col" class="px-6 pt-6 xl:px-8 xl:pt-8">
                            <div class="text-center text-base/8 font-semibold text-gray-900">Lifetime</div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($stats as $category)
                        <tr>
                            <th
                                scope="colgroup"
                                colspan="{{ ($settings->timeframe === PostingTimeframe::Monthly) ? 4 : 5 }}"
                                @class([
                                    'pb-4 text-sm/6 font-semibold text-gray-900',
                                    'pt-4' => $loop->first,
                                    'pt-16' => ! $loop->first,
                                ])
                            >
                                <div class="flex items-center gap-x-1.5">
                                    {{ $category->label }}

                                    @if (filled($category->hint))
                                        <div x-tooltip.raw="{{ $category->hint }}">
                                            <x-icon.micro.question-mark-circle
                                                class="size-4 text-gray-400 dark:text-gray-600"
                                            ></x-icon.micro.question-mark-circle>
                                        </div>
                                    @endif
                                </div>
                                <div class="absolute inset-x-8 mt-4 h-px bg-gray-900/10"></div>
                            </th>
                        </tr>

                        @foreach ($category->stats as $line)
                            <tr>
                                <th scope="row" class="py-4 text-sm/6 font-normal text-gray-900">
                                    {{ $line->label }}
                                    <div class="absolute inset-x-8 mt-4 h-px bg-gray-900/5"></div>
                                </th>
                                @unless ($settings->isMonthlyTimeframe())
                                    <td class="px-6 py-4 xl:px-8">
                                        <div
                                            class="text-center text-sm/6 font-medium tabular-nums text-gray-600 dark:text-gray-400"
                                        >
                                            @if (filled($line->currentTimeframe))
                                                {{ $line->currentTimeframe }}
                                            @else
                                                <svg
                                                    class="mx-auto size-5 text-gray-400 dark:text-gray-600"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                    aria-hidden="true"
                                                    data-slot="icon"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M4 10a.75.75 0 0 1 .75-.75h10.5a.75.75 0 0 1 0 1.5H4.75A.75.75 0 0 1 4 10Z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            @endif
                                        </div>
                                    </td>
                                @endunless

                                <td class="px-6 py-4 xl:px-8">
                                    <div
                                        class="text-center text-sm/6 font-medium tabular-nums text-gray-600 dark:text-gray-400"
                                    >
                                        @if (filled($line->lastMonth))
                                            {{ $line->lastMonth }}
                                        @else
                                            <svg
                                                class="mx-auto size-5 text-gray-400 dark:text-gray-600"
                                                viewBox="0 0 20 20"
                                                fill="currentColor"
                                                aria-hidden="true"
                                                data-slot="icon"
                                            >
                                                <path
                                                    fill-rule="evenodd"
                                                    d="M4 10a.75.75 0 0 1 .75-.75h10.5a.75.75 0 0 1 0 1.5H4.75A.75.75 0 0 1 4 10Z"
                                                    clip-rule="evenodd"
                                                />
                                            </svg>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 xl:px-8">
                                    <div
                                        class="text-center text-sm/6 font-medium tabular-nums text-gray-600 dark:text-gray-400"
                                    >
                                        @if (filled($line->thisMonth))
                                            {{ $line->thisMonth }}
                                        @else
                                            <svg
                                                class="mx-auto size-5 text-gray-400 dark:text-gray-600"
                                                viewBox="0 0 20 20"
                                                fill="currentColor"
                                                aria-hidden="true"
                                                data-slot="icon"
                                            >
                                                <path
                                                    fill-rule="evenodd"
                                                    d="M4 10a.75.75 0 0 1 .75-.75h10.5a.75.75 0 0 1 0 1.5H4.75A.75.75 0 0 1 4 10Z"
                                                    clip-rule="evenodd"
                                                />
                                            </svg>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 xl:px-8">
                                    <div
                                        class="text-center text-sm/6 font-medium tabular-nums text-gray-600 dark:text-gray-400"
                                    >
                                        @if (filled($line->lifetime))
                                            {{ $line->lifetime }}
                                        @else
                                            <svg
                                                class="mx-auto size-5 text-gray-400 dark:text-gray-600"
                                                viewBox="0 0 20 20"
                                                fill="currentColor"
                                                aria-hidden="true"
                                                data-slot="icon"
                                            >
                                                <path
                                                    fill-rule="evenodd"
                                                    d="M4 10a.75.75 0 0 1 .75-.75h10.5a.75.75 0 0 1 0 1.5H4.75A.75.75 0 0 1 4 10Z"
                                                    clip-rule="evenodd"
                                                />
                                            </svg>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-admin-layout>
