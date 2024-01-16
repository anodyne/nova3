<div>
    <div class="relative isolate overflow-hidden bg-gradient-to-b from-primary-100/20 pt-14">
        <div
            class="absolute inset-y-0 right-1/2 -z-10 -mr-96 w-[200%] origin-top-right skew-x-[-30deg] bg-white shadow-xl shadow-primary-600/10 ring-1 ring-primary-50 sm:-mr-80 lg:-mr-96"
            aria-hidden="true"
        ></div>
        <div class="mx-auto max-w-7xl px-6 py-32 sm:py-40 lg:px-8">
            <div
                class="mx-auto max-w-2xl lg:mx-0 lg:grid lg:max-w-none lg:grid-cols-2 lg:gap-x-16 lg:gap-y-6 xl:grid-cols-1 xl:grid-rows-1 xl:gap-x-8"
            >
                <h1
                    class="max-w-2xl text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl lg:col-span-2 xl:col-auto"
                >
                    {{ $heading }}
                </h1>
                <div class="mt-6 max-w-xl lg:mt-0 xl:col-end-1 xl:row-start-1">
                    <p class="text-lg leading-8 text-gray-600">
                        {{ $description }}
                    </p>
                    <div class="mt-10 flex items-center gap-x-6">
                        @if (filled($primary_button_label) && filled($primary_button_url))
                            <a
                                href="{{ $primary_button_url ?? '#' }}"
                                class="rounded-md bg-primary-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-primary-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600"
                            >
                                {{ $primary_button_label }}
                            </a>
                        @endif

                        @if (filled($secondary_button_label) && filled($secondary_button_url))
                            <a
                                href="{{ $secondary_button_url ?? '#' }}"
                                class="text-sm font-semibold leading-6 text-gray-900"
                            >
                                {{ $secondary_button_label }}
                                <span aria-hidden="true">→</span>
                            </a>
                        @endif
                    </div>
                </div>
                <img
                    src="https://legendary-digital-network-assets.s3.amazonaws.com/wp-content/uploads/2020/01/13062150/header-picard-char-posters.jpg"
                    alt=""
                    class="mt-10 aspect-[6/5] w-full max-w-lg rounded-2xl object-cover sm:mt-16 lg:mt-0 lg:max-w-none xl:row-span-2 xl:row-end-2 xl:mt-36"
                />
            </div>
        </div>
        <div class="absolute inset-x-0 bottom-0 -z-10 h-24 bg-gradient-to-t from-white sm:h-32"></div>
    </div>
</div>
