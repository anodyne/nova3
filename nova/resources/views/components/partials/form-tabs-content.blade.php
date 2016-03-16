@if ($tabs->count() > 0)
	<div class="tab-content">
	@foreach ($tabs as $tab)
		<div class="tab-pane" id="{{ $tab->link_id }}">
			@if ($tab->fieldsUnbound->count() > 0)
				{!! partial('form-fields', ['fields' => $tab->fieldsUnbound, 'editable' => $editable, 'form' => $form]) !!}
			@endif

			@if ($tab->childrenTabs->count() > 0)
				{!! partial('form-tabs-control', ['tabs' => $tab->childrenTabs, 'style' => 'pills', 'editable' => $editable, 'form' => $form]) !!}

				{!! partial('form-tabs-content', ['tabs' => $tab->childrenTabs, 'editable' => $editable, 'form' => $form]) !!}
			@endif

			{!! partial('form-sections', ['sections' => $tab->sections, 'editable' => $editable, 'form' => $form]) !!}
		</div>
	@endforeach
	</div>
@endif