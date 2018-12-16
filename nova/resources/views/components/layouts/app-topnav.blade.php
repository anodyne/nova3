<nav class="bg-white border-b py-3 text-grey-dark leading-normal">
	<div class="container">
		<div class="flex items-center sm:hidden">
			{{-- <nav-mobile></nav-mobile> --}}

			<nav-mobile-user :user="{{ $_user }}"></nav-mobile-user>
		</div>

		<div class="hidden sm:flex items-center justify-between">
			<div class="flex-1 text-sm">

				<div class="hidden">
					<a href="#" class="inline-flex text-grey-dark font-medium items-center hover:text-grey-darkest mr-6">
						Dashboard
					</a>
					<a href="#" class="inline-flex text-grey-dark font-medium items-center hover:text-grey-darkest mr-6">
						Pages
						<i data-feather="chevron-down" class="h-3 w-3 ml-1 leading-0"></i>
					</a>
					<a href="#" class="inline-flex text-grey-dark font-medium items-center hover:text-grey-darkest mr-6">
						Authentication
						<i data-feather="chevron-down" class="h-3 w-3 ml-1 leading-0"></i>
					</a>
					<a href="#" class="inline-flex text-grey-dark font-medium items-center hover:text-grey-darkest mr-6">
						Layouts
						<i data-feather="chevron-down" class="h-3 w-3 ml-1 leading-0"></i>
					</a>
					{{-- <a href="#" class="inline-flex text-grey-dark font-medium items-center hover:text-grey-darkest mr-6">
						Docs
						<i data-feather="chevron-down" class="h-3 w-3 ml-1 leading-0"></i>
					</a> --}}
				</div>
			</div>

			<div class="flex-shrink leading-0">
				{{-- {{ svg_icon('setup/anodyne', 'h-12 w-12') }} --}}
			</div>

			<div class="hidden flex-1 justify-end">
				<div class="hidden flex items-center">
					<div class="hidden items-center mr-6 rounded-full border py-2 px-4 w-72 text-grey">
						<app-icon name="search" icon-class="mr-2 h-5 w-5"></app-icon>
						<input type="text" class="w-full" placeholder="Search...">
					</div>

					<a href="#" class="text-grey hover:text-grey-darker leading-0 mr-6">
						<app-icon name="notification" icon-class="h-5 w-5"></app-icon>
					</a>

					<app-avatar
						:item="{{ $_user->toJson() }}"
						:show-content="false"
						:show-status="false"
						size="sm"
						type="image"
					></app-avatar>
					<app-icon name="chevron-down" icon-class="h-4 w-4 ml-1"></app-icon>
				</div>
			</div>
		</div>
	</div>
</nav>

<div class="container my-6">
	<main>
		{!! $template ?? false !!}
	</main>
</div>