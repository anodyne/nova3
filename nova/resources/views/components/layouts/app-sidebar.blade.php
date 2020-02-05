<div class="layout-app-sidebar">
    <nav class="sidebar">
        <div>
            <a href="#" class="flex justify-center my-6 leading-0">
                {{-- {{ svg_icon('setup/anodyne', 'h-16 w-16') }} --}}
            </a>

            <div class="flex flex-col -mx-6">
                <a href="#" class="sidebar-link">
                    <div class="flex items-center">
                        <icon name="home" class="mr-3"></icon>
                        Dashboard
                    </div>
                </a>
                <a href="#" class="sidebar-link">
                    <div class="flex items-center">
                        <icon name="file" class="mr-3"></icon>
                        Pages
                    </div>
                    <icon name="chevron-down" class="h-4 w-4"></icon>
                </a>
                <a href="#" class="sidebar-link">
                    <div class="flex items-center">
                        <icon name="user" class="mr-3"></icon>
                        Authentication
                    </div>
                    <icon name="chevron-down" class="h-4 w-4"></icon>
                </a>
                <a href="#" class="sidebar-link">
                    <div class="flex items-center">
                        <icon name="layout" class="mr-3"></icon>
                        Layouts
                    </div>
                    <icon name="chevron-down" class="h-4 w-4"></icon>
                </a>
            </div>

            <div class="sidebar-divider"></div>

            <div class="sidebar-header">Documentation</div>

            <div class="flex flex-col -mx-6">
                <a href="#" class="sidebar-link">
                    <div class="flex items-center">
                        <icon name="clipboard" class="mr-3"></icon>
                        Getting started
                    </div>
                </a>
                <a href="#" class="sidebar-link">
                    <div class="flex items-center">
                        <icon name="book-open" class="mr-3"></icon>
                        Components
                    </div>
                    <icon name="chevron-down" class="h-4 w-4"></icon>
                </a>
                <a href="#" class="sidebar-link">
                    <div class="flex items-center">
                        <icon name="git-branch" class="mr-3"></icon>
                        Changelog
                    </div>
                    <div class="rounded bg-blue text-white text-2xs py-1 px-2">v1.0</div>
                </a>
                <a
                    href="{{ route('logout') }}"
                    class="sidebar-link"
                    onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                >
                    <div class="flex items-center">
                        <icon name="sign-out" class="mr-3"></icon>
                        Log out
                    </div>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>

        <div class="sidebar-footer">
            <a href="#" class="sidebar-footer-link">
                <icon name="bell"></icon>
            </a>

            <div class="flex items-center">
                <user-avatar :user="{{ Nova\Users\Models\User::first() }}" :show-meta="false"></user-avatar>
                {{-- <avatar :item="{{ $_user->toJson() }}"
                        :show-content="false"
                        :show-status="false"
                        type="image"></avatar>
                <icon name="chevron-down" size="small" classes="ml-1"></icon> --}}
                <icon name="chevron-down" class="h-4 w-4 ml-1 text-grey"></icon>
            </div>

            <a href="#" class="sidebar-footer-link">
                <icon name="search"></icon>
            </a>
        </div>
    </nav>

    <main>
        {!! $template ?? false !!}
    </main>
</div>