<div class="btn-toolbar">
	@if (Sentry::getUser()->hasAccess('user.create'))
		<div class="btn-group">
			<a href="{{ URL::to('admin/user/create') }}" class="btn btn-success icn-size-16">{{ $_icons['add'] }}</a>
		</div>
	@endif

	@if (Sentry::getUser()->allowed(['character.create', 'character.update', 'character.delete'], false))
		<div class="btn-group">
			<a href="{{ URL::to('admin/character/all') }}" class="btn btn-default icn-size-16 tooltip-top" title="{{ lang('Short.manage', lang('characters')) }}">{{ $_icons['user'] }}</a>
		</div>
	@endif
</div>

<div class="row">
	<div class="col-12 col-sm-6 col-lg-4">
		<div class="form-group">
			{{ Form::text('search', null, ['id' => 'user-search', 'class' => 'form-control', 'placeholder' => lang('Short.search', langConcat('for users'))]) }}
		</div>
	</div>
</div>

<div id="actives">
	<div class="nv-data-table nv-data-table-striped nv-data-table-bordered">
	@foreach($users as $user)
		<div class="row">
			<div class="col-12 col-sm-8 col-lg-9">
				<p><strong>{{ $user->name }}</strong></p>
				<p class="text-muted text-small">{{ $user->email }}</p>
			</div>

			<div class="col-12 col-sm-4 col-lg-3">
				<div class="btn-toolbar pull-right">
				@if ((Sentry::getUser()->hasLevel('user.update', 1) and Sentry::getUser()->id == $user->id)
						or Sentry::getUser()->hasLevel('user.update', 2))
					<div class="btn-group">
						<a href="#" class="btn btn-small btn-default icn-size-16">{{ $_icons['link'] }}</a>
						<a href="{{ URL::to('admin/user/edit/'.$user->id) }}" class="btn btn-small btn-default icn-size-16">{{ $_icons['edit'] }}</a>
					</div>
				@endif

				@if (Sentry::getUser()->hasAccess('user.delete'))
					<div class="btn-group">
						<a href="#" class="btn btn-small btn-danger js-user-action icn-size-16" data-action="delete" data-id="{{ $user->id }}">{{ $_icons['remove'] }}</a>
					</div>
				@endif
				</div>
			</div>
		</div>
	@endforeach
	</div>
</div>

<div id="all" class="hide">
	<p><em>{{ lang('short.users.doneSearching', lang('active'), lang('users')) }}</em></p>
	
	<div id="results" class="hide">
		<div id="results-name" class="hide">
			<h3>{{ langConcat('Results by Name') }}</h3>
			<ul class="unstyled"></ul>
		</div>
		
		<div id="results-email" class="hide">
			<h3>{{ langConcat('Results by Email_address') }}</h3>
			<ul class="unstyled"></ul>
		</div>
		
		<div id="results-characters" class="hide">
			<h3>{{ langConcat('Results by Action.linked Characters') }}</h3>
			<ul class="unstyled"></ul>
		</div>
	</div>
	
	<div id="no-results" class="hide">
		{{ partial('common/alert', ['content' => lang('error.notFound', lang('results'))]) }}
	</div>
</div>