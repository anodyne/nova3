<div class="page-header">
	<h1>Form Tabs <small>{!! $form->present()->name !!}</small></h1>
</div>

<div v-cloak>
	<phone-tablet>
		@can('create', $tab)
			<p><a href="{{ route('admin.forms.tabs.create', $form->key) }}" class="btn btn-success btn-lg btn-block">Add a Tab</a></p>
		@endcan

		@can('manage', $form)
			<p><a href="{{ route('admin.forms') }}" class="btn btn-default btn-lg btn-block">Back to Forms</a></p>
		@endcan
	</phone-tablet>
	<desktop>
		<div class="btn-toolbar">
			@can('create', $tab)
				<div class="btn-group">
					<a href="{{ route('admin.forms.tabs.create', $form->key) }}" class="btn btn-success">Add a Tab</a>
				</div>
			@endcan

			@can('manage', $form)
				<div class="btn-group">
					<a href="{{ route('admin.forms') }}" class="btn btn-default">Back to Forms</a>
				</div>
			@endcan
		</div>
	</desktop>
</div>

@if ($hasTabs)
	<div class="data-table data-table-striped data-table-bordered">
	@foreach ($tabs as $tab)
		<div class="row">
			<div class="col-md-6">
				<p class="lead"><strong>{{ $tab->present()->name }}</strong></p>
			</div>
			<div class="col-md-6" v-cloak>
				<phone-tablet>
					<div class="row">
						@can('edit', $tab)
							<div class="col-xs-12">
								<p><a href="{{ route('admin.forms.tabs.edit', [$form->key, $tab->id]) }}" class="btn btn-default btn-lg btn-block">Edit</a></p>
							</div>
						@endcan

						@can('remove', $tab)
							<div class="col-xs-12">
								<p><a href="#" class="btn btn-danger btn-lg btn-block" @click.prevent="removeForm({{ $form->key }})">Remove</a></p>
							</div>
						@endcan
					</div>
				</phone-tablet>
				<desktop>
					<div class="btn-toolbar pull-right">
						@can('edit', $tab)
							<div class="btn-group">
								<a href="{{ route('admin.forms.tabs.edit', [$form->key, $tab->id]) }}" class="btn btn-default">Edit</a>
							</div>
						@endcan

						@can('remove', $form)
							<div class="btn-group">
								<a href="#" class="btn btn-danger" data-form-key="{{ $form->key }}" @click.prevent="removeForm">Remove</a>
							</div>
						@endcan
					</div>
				</desktop>
			</div>
		</div>

		@if ($tab->childrenTabs->count() > 0)
			@foreach ($tab->childrenTabs->sortBy('order') as $child)
				<div class="row">
					<div class="col-md-6">
						<p class="lead"><strong>{{ $child->present()->name }}</strong></p>
						<p class="text-muted"><em>Parent Tab: {{ $child->parentTab->present()->name }}</em></p>
					</div>
					<div class="col-md-6" v-cloak>
						<phone-tablet>
							<div class="row">
								@can('edit', $child)
									<div class="col-xs-12">
										<p><a href="{{ route('admin.forms.tabs.edit', [$form->key, $child->id]) }}" class="btn btn-default btn-lg btn-block">Edit</a></p>
									</div>
								@endcan

								@can('remove', $child)
									<div class="col-xs-12">
										<p><a href="#" class="btn btn-danger btn-lg btn-block" @click.prevent="removeForm({{ $form->key }})">Remove</a></p>
									</div>
								@endcan
							</div>
						</phone-tablet>
						<desktop>
							<div class="btn-toolbar pull-right">
								@can('edit', $child)
									<div class="btn-group">
										<a href="{{ route('admin.forms.tabs.edit', [$form->key, $child->id]) }}" class="btn btn-default">Edit</a>
									</div>
								@endcan

								@can('remove', $child)
									<div class="btn-group">
										<a href="#" class="btn btn-danger" data-form-key="{{ $form->key }}" @click.prevent="removeForm">Remove</a>
									</div>
								@endcan
							</div>
						</desktop>
					</div>
				</div>
			@endforeach
		@endif
	@endforeach
	</div>

	@can('remove', $form)
		{!! modal(['id' => "removeTab", 'header' => "Remove Form Tab"]) !!}
	@endcan
@else
	{!! alert('warning', "No form tabs found.") !!}
@endif