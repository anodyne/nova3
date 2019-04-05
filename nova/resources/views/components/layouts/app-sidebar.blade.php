<div class="layout-app-sidebar">
    <nav class="sidebar">
        <div>
            <a href="#" class="flex justify-center my-6 leading-zero">
                {{-- {{ svg_icon('setup/anodyne', 'h-16 w-16') }} --}}
            </a>

            <div class="flex flex-col -mx-6">
                <a href="#" class="sidebar-link">
                    <div class="flex items-center">
                        <nova-icon name="home" class="mr-3"></nova-icon>
                        Dashboard
                    </div>
                </a>
                <a href="#" class="sidebar-link">
                    <div class="flex items-center">
                        <nova-icon name="file" class="mr-3"></nova-icon>
                        Pages
                    </div>
                    <nova-icon name="chevron-down" class="h-4 w-4"></nova-icon>
                </a>
                <a href="#" class="sidebar-link">
                    <div class="flex items-center">
                        <nova-icon name="user" class="mr-3"></nova-icon>
                        Authentication
                    </div>
                    <nova-icon name="chevron-down" class="h-4 w-4"></nova-icon>
                </a>
                <a href="#" class="sidebar-link">
                    <div class="flex items-center">
                        <nova-icon name="layout" class="mr-3"></nova-icon>
                        Layouts
                    </div>
                    <nova-icon name="chevron-down" class="h-4 w-4"></nova-icon>
                </a>
            </div>

            <div class="sidebar-divider"></div>

            <div class="sidebar-header">Documentation</div>

            <div class="flex flex-col -mx-6">
                <a href="#" class="sidebar-link">
                    <div class="flex items-center">
                        <nova-icon name="clipboard" class="mr-3"></nova-icon>
                        Getting started
                    </div>
                </a>
                <a href="#" class="sidebar-link">
                    <div class="flex items-center">
                        <nova-icon name="book-open" class="mr-3"></nova-icon>
                        Components
                    </div>
                    <nova-icon name="chevron-down" class="h-4 w-4"></nova-icon>
                </a>
                <a href="#" class="sidebar-link">
                    <div class="flex items-center">
                        <nova-icon name="git-branch" class="mr-3"></nova-icon>
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
                        <nova-icon name="sign-out" class="mr-3"></nova-icon>
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
                <nova-icon name="notification"></nova-icon>
            </a>

            <div class="flex items-center">
                <user-avatar :user="{{ Nova\Users\User::first() }}" :show-meta="false"></user-avatar>
                {{-- <avatar :item="{{ $_user->toJson() }}"
                        :show-content="false"
                        :show-status="false"
                        type="image"></avatar>
                <icon name="chevron-down" size="small" classes="ml-1"></icon> --}}
                <nova-icon name="chevron-down" class="h-4 w-4 ml-1 text-grey"></nova-icon>
            </div>

            <a href="#" class="sidebar-footer-link">
                <nova-icon name="search"></nova-icon>
            </a>
        </div>
    </nav>

    <main>
        {!! $template ?? false !!}
    </main>
</div>