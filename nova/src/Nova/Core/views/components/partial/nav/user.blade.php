<ul class="nav pull-right">
	@if ($loggedIn)
		<li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				@if ($notifyTotal > 0)
					<span class="label{{ $notifyClass }}">{{ $notifyTotal }}</span>
				@endif
				{{ $name }} <b class="caret"></b>
			</a>

			<ul class="dropdown-menu">
			@foreach ($data as $key => $section)
				@if ($key != 0)
					<li class="divider"></li>
				@endif
				
				@foreach ($section as $item)
					<li>{{ Html::link($item['url'], $item['name'].$item['additional'], $item['extra']) }}</li>
				@endforeach
			@endforeach
			</ul>
		</li>
	@else
		<li>{{ Html::link('login/index', $loginText) }}</li>
	@endif
</ul>