<nav class="flex flex-col items-stretch justify-between fixed w-72 bg-white border-r h-screen py-3 px-6 text-grey-dark leading-normal">
	<div>
		<a href="#" class="flex justify-center my-6 leading-0">
			{{-- {{ svg_icon('setup/anodyne', 'h-16 w-16') }} --}}
		</a>

		<div class="flex flex-col -mx-6">
			<a href="#" class="flex justify-between no-underline text-grey-dark font-medium py-2 px-6 flex items-center hover:text-grey-darkest">
				<div class="flex items-center">
					<i data-feather="home" class="h-5 w-5 mr-3"></i>
					Dashboard
				</div>
			</a>
			<a href="#" class="flex justify-between no-underline text-grey-dark font-medium py-2 px-6 flex items-center hover:text-grey-darkest">
				<div class="flex items-center">
					<i data-feather="file" class="h-5 w-5 mr-3"></i>
					Pages
				</div>
				<i data-feather="chevron-down" class="h-4 w-4"></i>
			</a>
			<a href="#" class="flex justify-between no-underline text-grey-dark font-medium py-2 px-6 flex items-center hover:text-grey-darkest">
				<div class="flex items-center">
					<i data-feather="user" class="h-5 w-5 mr-3"></i>
					Authentication
				</div>
				<i data-feather="chevron-down" class="h-4 w-4"></i>
			</a>
			<a href="#" class="flex justify-between no-underline text-grey-dark font-medium py-2 px-6 flex items-center hover:text-grey-darkest">
				<div class="flex items-center">
					<i data-feather="layout" class="h-5 w-5 mr-3"></i>
					Layouts
				</div>
				<i data-feather="chevron-down" class="h-4 w-4"></i>
			</a>
		</div>

		<div class="my-3 border-t"></div>

		<div class="text-xs uppercase tracking-wide py-3 text-grey font-medium">Documentation</div>

		<div class="flex flex-col -mx-6">
			<a href="#" class="flex justify-between no-underline text-grey-dark font-medium py-2 px-6 flex items-center hover:text-grey-darkest">
				<div class="flex items-center">
					<i data-feather="clipboard" class="h-5 w-5 mr-3"></i>
					Getting started
				</div>
			</a>
			<a href="#" class="flex justify-between no-underline text-grey-dark font-medium py-2 px-6 flex items-center hover:text-grey-darkest">
				<div class="flex items-center">
					<i data-feather="book-open" class="h-5 w-5 mr-3"></i>
					Components
				</div>
				<i data-feather="chevron-down" class="h-4 w-4"></i>
			</a>
			<a href="#" class="flex justify-between no-underline text-grey-dark font-medium py-2 px-6 flex items-center hover:text-grey-darkest">
				<div class="flex items-center">
					<i data-feather="git-branch" class="h-5 w-5 mr-3"></i>
					Changelog
				</div>
				<div class="rounded bg-blue text-white text-2xs py-1 px-2">v1.0</div>
			</a>
		</div>
	</div>

	<div class="flex flex-row items-center justify-around -mx-6 border-t pt-3 px-6">
		<a href="#" class="no-underline text-grey hover:text-grey-darker leading-0">
			<i data-feather="bell" class="h-5 w-5"></i>
		</a>

		<div class="flex items-center">
			<avatar :item="{{ $_user->toJson() }}"
					:show-content="false"
					:show-status="true"
					type="image"
			></avatar>
			<icon name="chevron-down" size="small" classes="ml-1"></icon>
		</div>

		<a href="#" class="no-underline text-grey hover:text-grey-darker leading-0">
			<i data-feather="search" class="h-5 w-5"></i>
		</a>
	</div>
</nav>

<main class="flex-1 ml-72 py-6 px-12">
	{!! $template ?? '' !!}
</main>
