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
			{{ Form::text('search', null, ['id' => 'user-search', 'class' => 'form-control', 'placeholder' => lang('short.admin.users.searchPlaceholder')]) }}
		</div>
	</div>
	<div class="col-12 col-sm-2 col-lg-2">
		<div id="searching" class="hide">{{ HTML::image(SRCURL.'core/views/design/images/loading.gif') }}</div>
		<div id="searchComplete" class="hide">
			<a class="btn btn-small btn-default icn-size-16" rel="changeUserView" id="showActive">{{ $_icons['close'] }}</a>
		</div>
	</div>
</div>

<div id="activeUsers">
	<div class="nv-data-table nv-data-table-striped nv-data-table-bordered">
	@foreach($users as $user)
		<div class="row">
			<div class="col-12 col-sm-4 col-lg-4">
				<p><strong>{{ $user->name }}</strong></p>
				<p class="text-muted text-small">{{ $user->email }}</p>
			</div>

			<div class="col-12 col-sm-4 col-lg-4">
				@if ($user->getPrimaryCharacter() !== null)
					<p><strong>{{ $user->getPrimaryCharacter()->getNameWithRank() }}</strong></p>
				@else
					<p class="text-danger"><strong>{{ lang('short.admin.users.noPrimaryCharacter') }}</strong></p>
				@endif
			</div>

			<div class="col-12 col-sm-4 col-lg-4">
				<div class="btn-toolbar pull-right">
					<div class="btn-group">
						@if (Sentry::getUser()->hasLevel('user.update', 2))
							<a href="#" class="btn btn-small btn-default icn-size-16 js-user-action" data-action="link" data-id="{{ $user->id }}">{{ $_icons['link'] }}</a>
						@endif

						@if ((Sentry::getUser()->hasLevel('user.update', 1) and Sentry::getUser()->id == $user->id)
								or Sentry::getUser()->hasLevel('user.update', 2))
							<a href="{{ URL::to('admin/user/edit/'.$user->id) }}" class="btn btn-small btn-default icn-size-16">{{ $_icons['edit'] }}</a>
						@endif
					</div>

					@if (Sentry::getUser()->hasAccess('user.delete') and $user->canBeDeleted())
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

<div id="allUsers" class="hide">
	<p class="text-small text-muted"><em>{{ lang('short.admin.users.doneSearching', lang('active'), lang('users')) }}</em></p>
	
	<div id="results" class="hide">
		<div id="results-name" class="hide">
			<dl>
				<dt>{{ langConcat('Results by name') }}</dt>
			</dl>
		</div>
		
		<div id="results-email" class="hide">
			<dl>
				<dt>{{ langConcat('Results by email_address') }}</dt>
			</dl>
		</div>
		
		<div id="results-characters" class="hide">
			<dl>
				<dt>{{ langConcat('Results by linked characters') }}</dt>
			</dl>
		</div>
	</div>
	
	<div id="no-results" class="hide">
		{{ partial('common/alert', ['content' => lang('error.notFound', lang('results'))]) }}
	</div>
</div>