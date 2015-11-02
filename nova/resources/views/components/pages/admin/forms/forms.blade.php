<phone-tablet>
	@can('create', $form)
		<p><a href="{{ route('admin.forms.create') }}" class="btn btn-success btn-lg btn-block">Add a Form</a></p>
	@endcan
</phone-tablet>

<desktop>
	<div class="btn-toolbar">
		@can('create', $form)
			<div class="btn-group">
				<a href="{{ route('admin.forms.create') }}" class="btn btn-success">Add a Form</a>
			</div>
		@endcan
	</div>
</desktop>

<div class="data-table data-table-striped data-table-bordered">
@foreach ($forms as $form)
	<div class="row">
		<div class="col-md-6">
			<p class="lead"><strong>{{ $form->present()->name }}</strong></p>
			<p><strong>Key:</strong> {{ $form->present()->key }}</p>
		</div>
		<div class="col-md-6">
			<phone-tablet>
				<div class="row">
					<div class="col-xs-12">
						<p><a href="{{ route('admin.forms.preview', [$form->key]) }}" class="btn btn-default btn-lg btn-block">Preview</a></p>
					</div>

					@can('edit', $form)
						<div class="col-xs-12">
							<p><a href="{{ route('admin.forms.edit', [$form->key]) }}" class="btn btn-default btn-lg btn-block">Edit</a></p>
						</div>
					@endcan

					@can('remove', $form)
						<div class="col-xs-12">
							<p><a href="#" class="btn btn-danger btn-lg btn-block js-roleAction" data-id="{{ $form->id }}" data-action="remove">Remove</a></p>
						</div>
					@endcan
				</div>
			</phone-tablet>

			<desktop>
				<div class="btn-toolbar pull-right">
					<div class="btn-group">
						<a href="{{ route('admin.forms.preview', [$form->key]) }}" class="btn btn-default">Preview</a>
					</div>

					@can('edit', $form)
						<div class="btn-group">
							<a href="{{ route('admin.forms.edit', [$form->key]) }}" class="btn btn-default">Edit</a>
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
								<span class="caret"></span>
								<span class="sr-only">Toggle Dropdown</span>
							</button>
							<ul class="dropdown-menu dropdown-menu-right" role="menu">
								@can('manage', $formTab)
									<li><a href="{{ route('admin.menus.items', [$form->key]) }}">Form Tabs</a></li>
								@endcan

								@can('manage', $formSection)
									<li><a href="{{ route('admin.menus.items', [$form->key]) }}">Form Sections</a></li>
								@endcan

								@can('manage', $formField)
									<li><a href="{{ route('admin.menus.items', [$form->key]) }}">Form Fields</a></li>
								@endcan
							</ul>
						</div>
					@endcan

					@can('remove', $form)
						<div class="btn-group">
							<a href="#" class="btn btn-danger js-roleAction" data-id="{{ $form->id }}" data-action="remove">Remove</a>
						</div>
					@endcan
				</div>
			</desktop>
		</div>
	</div>
@endforeach
</div>

@can('remove', $form)
	{!! modal(['id' => "removeRole", 'header' => "Remove Role"]) !!}
@endcan