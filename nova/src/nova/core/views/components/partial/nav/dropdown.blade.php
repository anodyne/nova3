<div class="navbar navbar-fixed-top">
	<div class="container">
		<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>

		<a href="{{ URL::to('/') }}" class="navbar-brand">{{ $name }}</a>

		<div class="nav-collapse collapse navbar-responsive-collapse">
			<ul class="nav navbar-nav">
			@foreach ($items[$section]['mainNavItems'] as $mainNavItem)

				@if (isset($items[$section][$mainNavItem->category]))
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ $mainNavItem->name }} <b class="caret"></b></a>

						<ul class="dropdown-menu">
						@foreach ($items[$section][$mainNavItem->category] as $i)
							@if ($i->order == 0 and $i->group != 0)
								<li class="divider"></li>
							@endif

							<li>{{ HTML::link($i->url, $i->name) }}</li>
						@endforeach
						</ul>
					</li>
				@else
					<li>{{ HTML::link($mainNavItem->url, $mainNavItem->name) }}</li>
				@endif

			@endforeach
			</ul>

			{{ $userMenu }}
		</div>
	</div>
</div>