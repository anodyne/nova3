<div v-cloak>
	<phone-tablet>
		@can('create', $form)
			<p><a href="{{ route('admin.forms.create') }}" class="btn btn-success btn-lg btn-block">Add a Tab</a></p>
		@endcan
	</phone-tablet>
	<desktop>
		<div class="btn-toolbar">
			@can('create', $form)
				<div class="btn-group">
					<a href="{{ route('admin.forms.create') }}" class="btn btn-success">Add a Tab</a>
				</div>
			@endcan
		</div>
	</desktop>
</div>

@if ($tabs->count() > 0)
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
								<p><a href="{{ route('admin.forms.edit', [$form->key]) }}" class="btn btn-default btn-lg btn-block">Edit</a></p>
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
								<a href="{{ route('admin.forms.edit', [$form->key]) }}" class="btn btn-default">Edit</a>
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
	@endforeach
	</div>

	@can('remove', $form)
		{!! modal(['id' => "removeTab", 'header' => "Remove Tab"]) !!}
	@endcan
@else
	{!! alert('warning', "No form tabs found.") !!}
@endif