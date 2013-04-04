<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
			<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</a>

			{{ Html::link('main/index', $name, array('class' => 'brand')) }}

			<div class="nav-collapse">
				{{ $userMenu }}

				<ul class="nav">
				@foreach ($items[$section]['mainNavItems'] as $mainNavItem)

					@if (isset($items[$section][$mainNavItem->category]))
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ $mainNavItem->name }} <b class="caret"></b></a>

							<ul class="dropdown-menu">
							@foreach ($items[$section][$mainNavItem->category] as $i)
								@if ($i->order == 0 and $i->group != 0)
									<li class="divider"></li>
								@endif

								<li>{{ Html::link($i->url, $i->name) }}</li>
							@endforeach
							</ul>
						</li>
					@else
						<li>{{ Html::link($mainNavItem->url, $mainNavItem->name) }}</li>
					@endif

				@endforeach
				</ul>
			</div>
		</div>
	</div>
</div>