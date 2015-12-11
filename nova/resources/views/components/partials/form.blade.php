@if ($tabs->count() > 0)
	<ul class="nav nav-tabs">
	@foreach ($parentTabs as $tab)
		<li><a href="#{{ $tab->link_id }}" data-toggle="tab">{!! $tab->present()->name !!}</a></li>
	@endforeach
	</ul>

	<div class="tab-content">
	@foreach ($parentTabs as $parentTab)
		<div class="tab-pane" id="{{ $parentTab->link_id }}">
			@if ($parentTab->childrenTabs->count() > 0)
				<ul class="nav nav-pills">
				@foreach ($parentTab->childrenTabs as $childTab)
					<li><a href="#{{ $childTab->link_id }}" data-toggle="tab">{!! $childTab->present()->name !!}</a></li>
				@endforeach
				</ul>

				<div class="tab-content">
				@foreach ($parentTab->childrenTabs as $childTab)
					<div class="tab-pane" id="{{ $childTab->link_id }}">
						{!! partial('form-sections', ['sections' => $childTab->sections]) !!}
					</div>
				@endforeach
				</div>
			@endif

			{!! partial('form-sections', ['sections' => $parentTab->sections]) !!}
		</div>
	@endforeach
	</div>
@endif