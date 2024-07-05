@extends($meta->structure)

@push('styles')
    <link rel="stylesheet" href="{{ asset('themes/titan/design/theme.css') }}" />
@endpush

@section('layout')
    <div class="mx-auto flex h-full max-w-7xl flex-col py-6">
        <header class="relative flex">
            <div class="w-12 space-y-1">
                <div class="h-6 w-full rounded-tl rounded-tr-[1px] bg-[--grayDarker]"></div>
                <div class="h-2 w-full rounded-bl rounded-br-[1px] bg-[--grayDark]"></div>
            </div>

            <nav class="flex items-center px-4">
                <ul
                    class="flex items-center gap-x-6 *:cursor-pointer *:font-[family-name:--font-header] *:text-2xl *:font-semibold *:uppercase *:tracking-tight *:text-[--grayLight] *:transition hover:*:text-white [&>[data-active]]:text-[--cyanLighter]"
                >
                    <li data-active>Main</li>
                    <li>Personnel</li>
                    <li>Game</li>
                    <li>Wiki</li>
                    <li>Log in</li>
                </ul>
            </nav>

            <div class="flex-1 space-y-1">
                <div class="h-6 w-full rounded-t-[1px] bg-[--grayDarker]"></div>
                <div class="h-2 w-full rounded-b-[1px] bg-[--grayDark]"></div>
            </div>

            <div class="bg-[--black] px-4">
                <h1
                    class="font-[family-name:--font-header] text-4xl font-bold uppercase leading-8 tracking-tight text-[--orangeLight]"
                >
                    {{ settings('general.gameName') }}
                </h1>
            </div>

            <div class="w-12 space-y-1">
                <div class="h-6 w-full rounded-tl-[1px] rounded-tr bg-[--grayDarker]"></div>
                <div class="h-2 w-full rounded-bl-[1px] rounded-br bg-[--grayDark]"></div>
            </div>
        </header>

        <main class="relative mt-8 flex bg-[--grayDark]">
            <div
                class="absolute right-0 top-4 z-10 h-16 w-[calc(100%-theme(spacing.24))] rounded-tl-[60px] border-l-[1.5px] border-t-[1.5px] border-[--black] bg-[--grayLight]"
            ></div>

            <div class="w-40 space-y-3 bg-[--black]">
                <div class="relative w-full rounded-tl-[80px] bg-[--grayDark] pt-20">
                    <ul
                        class="space-y-1.5 bg-[--black] py-3 *:relative *:cursor-pointer *:rounded-sm *:bg-[--grayDarker] *:px-2 *:py-0.5 *:font-[family-name:--font-header] *:text-lg *:font-semibold *:uppercase *:tracking-tight *:text-[--grayLighter] *:transition *:before:absolute *:before:bottom-1 *:before:right-1 *:before:size-1 *:before:bg-[--black] *:after:absolute *:after:bottom-3 *:after:right-1 *:after:size-1 *:after:bg-[--black] hover:*:bg-[--gray] [&>[data-active]]:bg-[--orange] [&>[data-active]]:text-white [&>[data-active]]:before:bg-[--orangeDark] [&>[data-active]]:after:bg-[--orangeLight]"
                    >
                        <li>Main</li>
                        <li data-active>News</li>
                        <li>Join</li>
                        <li>Log in</li>
                    </ul>
                </div>
            </div>

            <div class="z-50 mt-6 flex-1 rounded-tl-[40px] bg-[--black] px-8">
                <div class="h-14 w-full pt-4">
                    <div class="flex w-1/3 items-center space-x-1">
                        <div class="relative h-9 w-4 rounded-l-lg bg-[--gray]">
                            <div class="absolute inset-y-0 right-0 my-0.5 w-2 rounded-l-lg bg-[--black]"></div>
                        </div>

                        <div class="h-9 flex-1 border-y border-[--gray]">
                            <div class="grid h-[34px] grid-cols-12 gap-x-2 px-1 py-1">
                                <div class="grid gap-y-1">
                                    <div class="h-[3px] w-full rounded-full bg-[--grayDark]"></div>
                                    <div class="h-[3px] w-full rounded-full bg-[--grayDarker]"></div>
                                    <div
                                        class="animation-delay-200 animate-delay-200 h-[3px] w-full animate-pulse rounded-full bg-[--cyanDark]"
                                    ></div>
                                    <div
                                        class="animate-duration-3000 h-[3px] w-full animate-pulse rounded-full bg-[--cyan]"
                                    ></div>
                                </div>

                                <div class="grid gap-y-1">
                                    <div class="h-[3px] w-full rounded-full bg-[--cyan]"></div>
                                    <div
                                        class="animate-delay-2000 animate-duration-1000 h-[3px] w-full animate-pulse rounded-full bg-[--cyanLight]"
                                    ></div>
                                    <div class="h-[3px] w-full rounded-full bg-[--cyanLighter]"></div>
                                    <div
                                        class="animate-delay-500 animate-duration-5000 h-[3px] w-full animate-pulse rounded-full bg-[--cyanDark]"
                                    ></div>
                                </div>

                                <div class="grid gap-y-1">
                                    <div class="h-[3px] w-full rounded-full bg-[--grayLight]"></div>
                                    <div class="h-[3px] w-full rounded-full bg-[--grayDark]"></div>
                                    <div class="h-[3px] w-full rounded-full bg-[--orange]"></div>
                                    <div class="h-[3px] w-full rounded-full bg-[--cyan]"></div>
                                </div>

                                <div class="grid gap-y-1">
                                    <div class="h-[3px] w-full rounded-full bg-[--grayDark]"></div>
                                    <div class="h-[3px] w-full rounded-full bg-[--grayDarker]"></div>
                                    <div class="h-[3px] w-full rounded-full bg-[--grayDark]"></div>
                                    <div class="h-[3px] w-full rounded-full bg-[--grayLight]"></div>
                                </div>

                                <div class="grid gap-y-1">
                                    <div class="h-[3px] w-full rounded-full bg-[--cyan]"></div>
                                    <div class="h-[3px] w-full rounded-full bg-[--purple]"></div>
                                    <div class="h-[3px] w-full rounded-full bg-[--grayDarker]"></div>
                                    <div class="h-[3px] w-full rounded-full bg-[--gray]"></div>
                                </div>

                                <div class="grid gap-y-1">
                                    <div class="h-[3px] w-full rounded-full bg-[--grayDarker]"></div>
                                    <div class="h-[3px] w-full rounded-full bg-[--black]"></div>
                                    <div class="h-[3px] w-full rounded-full bg-[--cyan]"></div>
                                    <div class="h-[3px] w-full rounded-full bg-[--grayDarker]"></div>
                                </div>

                                <div class="grid gap-y-1">
                                    <div class="h-[3px] w-full rounded-full bg-[--grayDark]"></div>
                                    <div class="h-[3px] w-full rounded-full bg-[--grayDark]"></div>
                                    <div class="h-[3px] w-full rounded-full bg-[--orangeDark]"></div>
                                    <div class="h-[3px] w-full rounded-full bg-[--grayDarker]"></div>
                                </div>

                                <div class="grid gap-y-1">
                                    <div class="h-[3px] w-full rounded-full bg-[--blue]"></div>
                                    <div class="h-[3px] w-full rounded-full bg-[--cyan]"></div>
                                    <div class="h-[3px] w-full rounded-full bg-[--grayDark]"></div>
                                    <div class="h-[3px] w-full rounded-full bg-[--grayDark]"></div>
                                </div>

                                <div class="grid gap-y-1">
                                    <div class="h-[3px] w-full rounded-full bg-[--grayDarker]"></div>
                                    <div class="h-[3px] w-full rounded-full bg-[--grayDark]"></div>
                                    <div class="h-[3px] w-full rounded-full bg-[--purpleDark]"></div>
                                    <div class="h-[3px] w-full rounded-full bg-[--cyanLight]"></div>
                                </div>

                                <div class="grid gap-y-1">
                                    <div class="h-[3px] w-full rounded-full bg-[--cyanDark]"></div>
                                    <div class="h-[3px] w-full rounded-full bg-[--cyanDark]"></div>
                                    <div class="h-[3px] w-full rounded-full bg-[--cyanLight]"></div>
                                    <div class="h-[3px] w-full rounded-full bg-[--grayDarker]"></div>
                                </div>

                                <div class="grid gap-y-1">
                                    <div class="h-[3px] w-full rounded-full bg-[--gray]"></div>
                                    <div class="h-[3px] w-full rounded-full bg-[--grayDark]"></div>
                                    <div class="h-[3px] w-full rounded-full bg-[--gray]"></div>
                                    <div class="h-[3px] w-full rounded-full bg-[--grayDark]"></div>
                                </div>

                                <div class="grid gap-y-1">
                                    <div class="h-[3px] w-full rounded-full bg-[--grayDark]"></div>
                                    <div class="h-[3px] w-full rounded-full bg-[--grayDarker]"></div>
                                    <div class="h-[3px] w-full rounded-full bg-[--black]"></div>
                                    <div class="h-[3px] w-full rounded-full bg-[--orange]"></div>
                                </div>
                            </div>
                        </div>

                        <div class="relative h-9 w-4 rounded-r-lg bg-[--gray]">
                            <div class="absolute inset-y-0 my-0.5 w-2 rounded-r-lg bg-[--black]"></div>
                        </div>
                    </div>
                </div>

                <div class="pb-16 pt-3 text-[--grayLighter]">
                    @yield('template')
                </div>
            </div>

            <div class="w-20 bg-[--black]">
                <div class="h-6 w-full bg-[--grayDark]"></div>
                <div
                    class="relative z-50 w-full space-y-1.5 bg-[--black] pt-3 *:flex *:items-center *:justify-end *:px-2 *:py-1 *:font-[family-name:--font-header] *:text-sm *:font-semibold *:tracking-tight"
                >
                    <div class="bg-[--cyan]">4.15-10</div>
                    <div class="bg-[--grayDarker] text-[--grayLight]">26-092</div>
                    <div class="bg-[--grayDark] text-[--grayLight]">4.47-0811</div>
                    <div class="animate animate-pulse bg-[--orange]">4.15-25</div>
                </div>
            </div>
        </main>
    </div>
@endsection

@section('layout-old')
    <div class="mx-auto flex h-full max-w-7xl flex-col">
        <header class="flex shrink-0">
            <nav class="w-40 space-y-1">
                <div class="h-[26px] w-full bg-[--grayDark]"></div>

                <div class="flex w-full gap-x-1.5">
                    <div class="w-[26px] bg-[--gray]"></div>

                    <ul class="flex-1 divide-y-[3px] divide-[--black] bg-[--black] font-[family-name:--font-header]">
                        <li class="relative flex space-x-1">
                            <div class="animate w-1.5 animate-pulse bg-[--gray]"></div>
                            <a
                                href=""
                                class="flex flex-1 justify-end bg-[--grayLighter] px-2 py-1 text-base font-bold uppercase tracking-tight text-[--black]"
                            >
                                Main
                            </a>
                        </li>
                        <li class="relative flex space-x-1">
                            <div class="w-1.5 bg-[--gray]"></div>
                            <a
                                href=""
                                class="flex flex-1 justify-end bg-[--grayLight] px-2 py-1 text-base font-bold uppercase tracking-tight text-[--black]"
                            >
                                Personnel
                            </a>
                        </li>
                        <li class="relative flex space-x-1">
                            <div class="w-1.5 bg-[--gray]"></div>
                            <a
                                href=""
                                class="flex flex-1 justify-end bg-[--grayLight] px-2 py-1 text-base font-bold uppercase tracking-tight text-[--black]"
                            >
                                Sim
                            </a>
                        </li>
                        <li class="relative flex space-x-1">
                            <div class="w-1.5 bg-[--gray]"></div>
                            <a
                                href=""
                                class="flex flex-1 justify-end bg-[--cyanLight] px-2 py-1 text-base font-bold uppercase tracking-tight text-[--black]"
                            >
                                Wiki
                            </a>
                        </li>
                        <li class="relative flex space-x-1">
                            <div class="w-1.5 bg-[--gray]"></div>
                            <a
                                href=""
                                class="flex flex-1 justify-end bg-[--gray] px-2 py-1 text-base font-bold uppercase tracking-tight text-[--black]"
                            >
                                Search
                            </a>
                        </li>
                        <li class="relative flex space-x-1">
                            <div class="w-1.5 bg-[--gray]"></div>
                            <a
                                href=""
                                class="flex flex-1 justify-end bg-[--orangeLight] px-2 py-1 text-base font-bold uppercase tracking-tight text-[--black]"
                            >
                                Admin
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="h-16 w-full rounded-bl-[3.5rem] bg-[--gray]"></div>
            </nav>
            <section class="relative flex-1 bg-[--gray]">
                <div class="absolute inset-0 z-10 mb-6 rounded-bl-[2.5rem] bg-[--black]"></div>
                <h1
                    class="absolute right-1 top-1 z-20 font-[family-name:--font-header] text-6xl font-bold uppercase tracking-tight text-[--grayLighter]"
                >
                    USS Titan
                </h1>
            </section>
        </header>

        <main class="relative mt-4 min-h-96 flex-1 rounded-tl-[3.5rem] bg-[--gray]">
            <div
                class="z-1 absolute left-10 top-2 h-[calc(100%-theme(spacing.2))] w-[calc(100%-theme(spacing.10))] rounded-tl-[3rem] border-l-[1.5px] border-t-[1.5px] border-[--black] bg-[--grayDark]"
            ></div>
            <div
                class="absolute left-40 top-4 z-10 h-[calc(100%-theme(spacing.4))] w-[calc(100%-theme(spacing.40))] rounded-tl-[2.5rem] bg-[--black]"
            ></div>

            <nav class="absolute left-0 top-16 w-40 border-y-[3px] border-[--black] bg-[--black]">
                <ul class="flex-1 divide-y-[3px] divide-[--black] bg-[--black] font-[family-name:--font-header]">
                    <li class="relative flex space-x-[3px]">
                        <div class="w-10 bg-[--gray]"></div>
                        <a
                            href=""
                            class="flex flex-1 justify-end bg-[--grayLighter] px-2 py-1 text-base font-bold uppercase tracking-tight text-[--black]"
                        >
                            Main
                        </a>
                    </li>
                    <li class="relative flex space-x-[3px]">
                        <div class="w-10 bg-[--cyanDark]"></div>
                        <a
                            href=""
                            class="flex flex-1 justify-end bg-[--cyan] px-2 py-1 text-base font-bold uppercase tracking-tight text-[--black]"
                        >
                            News
                        </a>
                    </li>
                    <li class="relative flex space-x-[3px]">
                        <div class="w-10 bg-[--grayDarker]"></div>
                        <a
                            href=""
                            class="flex flex-1 justify-end bg-[--grayDark] px-2 py-1 text-base font-bold uppercase tracking-tight text-[--black]"
                        >
                            Contact
                        </a>
                    </li>
                    <li class="relative flex space-x-[3px]">
                        <div class="w-10 bg-[--gray]"></div>
                        <a
                            href=""
                            class="flex flex-1 justify-end bg-[--grayLight] px-2 py-1 text-base font-bold uppercase tracking-tight text-[--black]"
                        >
                            Credits
                        </a>
                    </li>
                    <li class="relative flex space-x-[3px]">
                        <div class="w-10 bg-[--orangeDarker]"></div>
                        <a
                            href=""
                            class="flex flex-1 justify-end bg-[--orangeDark] px-2 py-1 text-base font-bold uppercase tracking-tight text-[--black]"
                        >
                            Join
                        </a>
                    </li>
                    <li class="relative flex space-x-[3px]">
                        <div class="w-10 bg-[--gray]"></div>
                        <a
                            href=""
                            class="flex flex-1 justify-end bg-[--grayLight] px-2 py-1 text-base font-bold uppercase tracking-tight text-[--black]"
                        >
                            Rules
                        </a>
                    </li>
                    <li class="relative flex space-x-[3px]">
                        <div class="w-10 bg-[--grayDark]"></div>
                        <a
                            href=""
                            class="flex flex-1 justify-end bg-[--gray] px-2 py-1 text-base font-bold uppercase tracking-tight text-[--black]"
                        >
                            Search
                        </a>
                    </li>
                </ul>
            </nav>

            <section class="relative z-50 ml-40 pt-4 text-white">
                @yield('template')
            </section>
        </main>
    </div>
@endsection
