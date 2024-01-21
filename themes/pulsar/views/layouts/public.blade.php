@extends($meta->structure)

@section('layout')
    <div class="mx-auto max-w-7xl">
        <header class="flex">
            <nav class="w-40 space-y-1">
                <div class="h-[26px] w-full bg-[--grayDark]"></div>

                <div class="flex w-full gap-x-1.5">
                    <div class="w-[26px] bg-[--gray]"></div>

                    <ul class="flex-1 divide-y-[3px] divide-[--black] bg-[--black]">
                        <li class="relative flex space-x-1">
                            <div class="animate w-1.5 animate-pulse bg-[--gray]"></div>
                            <a
                                href=""
                                class="flex flex-1 justify-end bg-[--grayLighter] px-2 py-1 text-base font-semibold uppercase tracking-tight text-[--black]"
                            >
                                Main
                            </a>
                        </li>
                        <li class="relative flex space-x-1">
                            <div class="w-1.5 bg-[--gray]"></div>
                            <a
                                href=""
                                class="flex flex-1 justify-end bg-[--grayLight] px-2 py-1 text-base font-semibold uppercase tracking-tight text-[--black]"
                            >
                                Personnel
                            </a>
                        </li>
                        <li class="relative flex space-x-1">
                            <div class="w-1.5 bg-[--gray]"></div>
                            <a
                                href=""
                                class="flex flex-1 justify-end bg-[--grayLight] px-2 py-1 text-base font-semibold uppercase tracking-tight text-[--black]"
                            >
                                Sim
                            </a>
                        </li>
                        <li class="relative flex space-x-1">
                            <div class="w-1.5 bg-[--gray]"></div>
                            <a
                                href=""
                                class="flex flex-1 justify-end bg-[--cyanLight] px-2 py-1 text-base font-semibold uppercase tracking-tight text-[--black]"
                            >
                                Wiki
                            </a>
                        </li>
                        <li class="relative flex space-x-1">
                            <div class="w-1.5 bg-[--gray]"></div>
                            <a
                                href=""
                                class="flex flex-1 justify-end bg-[--gray] px-2 py-1 text-base font-semibold uppercase tracking-tight text-[--black]"
                            >
                                Search
                            </a>
                        </li>
                        <li class="relative flex space-x-1">
                            <div class="w-1.5 bg-[--gray]"></div>
                            <a
                                href=""
                                class="flex flex-1 justify-end bg-[--orangeLight] px-2 py-1 text-base font-semibold uppercase tracking-tight text-[--black]"
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
                    class="absolute right-1 top-1 z-20 text-6xl font-bold uppercase tracking-tight text-[--grayLighter]"
                >
                    USS Titan
                </h1>
            </section>
        </header>

        <main class="relative mt-4 min-h-96 rounded-tl-[3.5rem] bg-[--gray]">
            <div
                class="z-1 absolute left-10 top-2 h-[calc(100%-theme(spacing.2))] w-[calc(100%-theme(spacing.10))] rounded-tl-[3rem] border-l-[1.5px] border-t-[1.5px] border-[--black] bg-[--grayDark]"
            ></div>
            <div
                class="absolute left-40 top-4 z-10 h-[calc(100%-theme(spacing.4))] w-[calc(100%-theme(spacing.40))] rounded-tl-[2.5rem] bg-[--black]"
            ></div>

            <nav class="absolute left-0 top-16 w-40 border-y-[3px] border-[--black] bg-[--black]">
                <ul class="flex-1 divide-y-[3px] divide-[--black] bg-[--black]">
                    <li class="relative flex space-x-[3px]">
                        <div class="w-10 bg-[--gray]"></div>
                        <a
                            href=""
                            class="flex flex-1 justify-end bg-[--grayLighter] px-2 py-1 text-base font-semibold uppercase tracking-tight text-[--black]"
                        >
                            Main
                        </a>
                    </li>
                    <li class="relative flex space-x-[3px]">
                        <div class="w-10 bg-[--cyanDark]"></div>
                        <a
                            href=""
                            class="flex flex-1 justify-end bg-[--cyan] px-2 py-1 text-base font-semibold uppercase tracking-tight text-[--black]"
                        >
                            News
                        </a>
                    </li>
                    <li class="relative flex space-x-[3px]">
                        <div class="w-10 bg-[--grayDarker]"></div>
                        <a
                            href=""
                            class="flex flex-1 justify-end bg-[--grayDark] px-2 py-1 text-base font-semibold uppercase tracking-tight text-[--black]"
                        >
                            Contact
                        </a>
                    </li>
                    <li class="relative flex space-x-[3px]">
                        <div class="w-10 bg-[--gray]"></div>
                        <a
                            href=""
                            class="flex flex-1 justify-end bg-[--grayLight] px-2 py-1 text-base font-semibold uppercase tracking-tight text-[--black]"
                        >
                            Credits
                        </a>
                    </li>
                    <li class="relative flex space-x-[3px]">
                        <div class="w-10 bg-[--orangeDarker]"></div>
                        <a
                            href=""
                            class="flex flex-1 justify-end bg-[--orangeDark] px-2 py-1 text-base font-semibold uppercase tracking-tight text-[--black]"
                        >
                            Join
                        </a>
                    </li>
                    <li class="relative flex space-x-[3px]">
                        <div class="w-10 bg-[--gray]"></div>
                        <a
                            href=""
                            class="flex flex-1 justify-end bg-[--grayLight] px-2 py-1 text-base font-semibold uppercase tracking-tight text-[--black]"
                        >
                            Rules
                        </a>
                    </li>
                    <li class="relative flex space-x-[3px]">
                        <div class="w-10 bg-[--grayDark]"></div>
                        <a
                            href=""
                            class="flex flex-1 justify-end bg-[--gray] px-2 py-1 text-base font-semibold uppercase tracking-tight text-[--black]"
                        >
                            Search
                        </a>
                    </li>
                </ul>
            </nav>

            <section class="relative z-50 ml-40 px-8 py-16 text-white">
                @yield('template')
            </section>
        </main>
    </div>
@endsection
