<nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-between">
    <div class="flex justify-between flex-1 sm:hidden">
        @if ($paginator->onFirstPage())
            <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-9 bg-white border border-gray-6 cursor-default rounded-md">
                {!! __('pagination.previous') !!}
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-11 bg-white border border-gray-6 rounded-md hover:text-gray-9 focus:outline-none focus:ring focus:border-blue-7 active:bg-gray-100 active:text-gray-11 transition ease-in-out duration-200">
                {!! __('pagination.previous') !!}
            </a>
        @endif

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-11 bg-white border border-gray-6 rounded-md hover:text-gray-9 focus:outline-none focus:ring focus:border-blue-7 active:bg-gray-100 active:text-gray-11 transition ease-in-out duration-200">
                {!! __('pagination.next') !!}
            </a>
        @else
            <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-9 bg-white border border-gray-6 cursor-default rounded-md">
                {!! __('pagination.next') !!}
            </span>
        @endif
    </div>

    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
        <div>
            <p class="text-sm text-gray-11">
                {!! __('Showing') !!}
                <span class="font-semibold">{{ $paginator->firstItem() }}</span>
                {!! __('to') !!}
                <span class="font-semibold">{{ $paginator->lastItem() }}</span>
                {!! __('of') !!}
                <span class="font-semibold">{{ $paginator->total() }}</span>
                {!! __('results') !!}
            </p>
        </div>

        <div>
            <span class="relative z-0 inline-flex shadow-sm">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                        <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-9 bg-white border border-gray-6 cursor-default rounded-l-md" aria-hidden="true">
                            <x-icon.chevron-left class="h-5 w-5" />
                        </span>
                    </span>
                @else
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-11 bg-white border border-gray-6 rounded-l-md hover:text-gray-12 focus:z-10 focus:outline-none focus:border-blue-7 focus:ring active:bg-gray-100 active:text-gray-11 transition ease-in-out duration-200" aria-label="{{ __('pagination.previous') }}">
                        <x-icon.chevron-left class="h-5 w-5" />
                    </a>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <span aria-disabled="true">
                            <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-9 bg-white border border-gray-6 cursor-default">{{ $element }}</span>
                        </span>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span aria-current="page">
                                    <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-12 bg-white border border-gray-6 cursor-default">{{ $page }}</span>
                                </span>
                            @else
                                <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-11 bg-white border border-gray-6 hover:text-gray-12 focus:z-10 focus:outline-none focus:border-blue-7 focus:ring active:bg-gray-3 active:text-gray-11 transition ease-in-out duration-200" aria-label="{{ __('pagination.goto_page', ['page' => $page]) }}">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-11 bg-white border border-gray-6 rounded-r-md hover:text-gray-12 focus:z-10 focus:outline-none focus:border-blue-7 focus:ring active:bg-gray-3 active:text-gray-12 transition ease-in-out duration-200" aria-label="{{ __('pagination.next') }}">
                        <x-icon.chevron-right class="h-5 w-5" />
                    </a>
                @else
                    <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                        <span class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-9 bg-white border border-gray-6 cursor-default rounded-r-md" aria-hidden="true">
                            <x-icon.chevron-right class="h-5 w-5" />
                        </span>
                    </span>
                @endif
            </span>
        </div>
    </div>
</nav>
