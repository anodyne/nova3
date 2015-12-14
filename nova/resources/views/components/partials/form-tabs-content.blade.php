@if ($tabs->count() > 0)
	<div class="tab-content">
	@foreach ($tabs as $tab)
		<div class="tab-pane" id="{{ $tab->link_id }}">
			@if ($tab->childrenTabs->count() > 0)
				{!! partial('form-tabs-control', ['tabs' => $tab->childrenTabs, 'style' => 'pills']) !!}

				{!! partial('form-tabs-content', ['tabs' => $tab->childrenTabs]) !!}
			@endif

			{!! partial('form-sections', ['sections' => $tab->sections]) !!}
		</div>
	@endforeach
	</div>
@endif