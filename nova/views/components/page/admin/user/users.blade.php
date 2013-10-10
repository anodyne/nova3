<div class="btn-toolbar">
	@if ($_currentUser->hasAccess('user.create'))
		<div class="btn-group">
			<a href="{{ URL::to('admin/user/create') }}" class="btn btn-success icn-size-16">{{ $_icons['add'] }}</a>
		</div>
	@endif

	@if ($_currentUser->allowed(['character.create', 'character.update', 'character.delete'], false))
		<!--<div class="btn-group">
			<a href="{{ URL::to('admin/character/all') }}" class="btn btn-default icn-size-16 tooltip-top" title="{{ lang('Short.manage', lang('characters')) }}">{{ $_icons['users'] }}</a>
		</div>-->
	@endif
</div>

<div class="row">
	<div class="col-xs-12 col-sm-6 col-lg-4">
		<div class="form-group">
			{{ Form::text('search', null, ['id' => 'user-search', 'class' => 'form-control', 'placeholder' => lang('short.admin.users.searchPlaceholder')]) }}
		</div>
	</div>
	<div class="col-xs-12 col-sm-2 col-lg-2">
		<div id="searching" class="hide">{{ HTML::image(SRCURL.'core/views/design/images/loading.gif') }}</div>
		<div id="searchComplete" class="hide">
			<p><a class="btn btn-sm btn-default icn-size-16" rel="changeUserView" id="showActive">{{ $_icons['closeSmall'] }}</a></p>
		</div>
	</div>
</div>

<div id="activeUsers">
	@if ($pending->count() > 0)
		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title">{{ langConcat('Pending Users') }}</h3>
			</div>

			<div class="panel-body">
				<div class="nv-data-table nv-data-table-striped nv-data-table-bordered">
				@foreach($pending as $p)
					<div class="row">
						<div class="col-xs-12 col-sm-5 col-lg-4">
							<p><strong>{{ $p->name }}</strong></p>
							<p class="text-muted text-small">{{ $p->email }}</p>
						</div>

						<div class="col-xs-12 col-sm-5 col-lg-4">
							@if ($p->getPrimaryCharacter() !== null)
								<p><strong>{{ $p->getPrimaryCharacter()->getNameWithRank() }}</strong></p>
							@else
								<p class="text-danger"><strong>{{ lang('short.admin.users.noPrimaryCharacter') }}</strong></p>
							@endif
						</div>

						<div class="col-xs-12 col-sm-2 col-lg-4">
							<div class="visible-lg">
								<div class="btn-toolbar pull-right">
									<div class="btn-group">
										<a href="{{ URL::to('admin/arc/') }}" class="btn btn-sm btn-default icn-size-16 tooltip-top" title="{{ lang('Short.go', lang('application_review_center')) }}">{{ $_icons['inProgress'] }}</a>
									</div>
								</div>
							</div>
							<div class="hidden-lg">
								<div class="row">
									<div class="col-xs-12">
										<p><a href="{{ URL::to('admin/arc/') }}" class="btn btn-lg btn-block btn-default icn-size-16">{{ $_icons['inProgress'] }}</a></p>
									</div>
								</div>
							</div>
						</div>
					</div>
				@endforeach
				</div>
			</div>
		</div>
	@endif

	<div class="nv-data-table nv-data-table-striped nv-data-table-bordered">
	@foreach($users as $user)
		<div class="row">
			<div class="col-xs-12 col-sm-2 col-lg-1">
				<p class="text-center">{{ partial('common/avatar', ['image' => $user->getAvatar('md'), 'alt' => $user->name]) }}</p>
			</div>
			<div class="col-xs-12 col-sm-4 col-lg-4">
				<p><strong>{{ $user->name }}</strong></p>
				<p class="text-muted text-small">{{ $user->email }}</p>
			</div>

			<div class="col-xs-12 col-sm-6 col-lg-4">
				@if ($user->getPrimaryCharacter() !== null)
					<p><strong>{{ $user->getPrimaryCharacter()->getNameWithRank() }}</strong></p>
				@else
					<p class="text-danger"><strong>{{ lang('short.admin.users.noPrimaryCharacter') }}</strong></p>
				@endif
				<p>&nbsp;</p>
			</div>

			<div class="col-xs-12 col-sm-12 col-lg-3">
				<div class="visible-lg">
					<div class="btn-toolbar pull-right">
						@if ($_currentUser->canEditUser($user))
							@if ($_currentUser->hasLevel('user.update', 2))
								<div class="btn-group">
									@if ($user->status == Status::ACTIVE)
										<a href="#" class="btn btn-sm btn-default tooltip-top icn-size-16" title="{{ lang('Short.deactivate', lang('User')) }}">{{ $_icons['reject'] }}</a>
									@endif

									@if ($user->status == Status::INACTIVE)
										<a href="#" class="btn btn-sm btn-default tooltip-top icn-size-16" title="{{ lang('Short.activate', lang('User')) }}">{{ $_icons['check'] }}</a>
									@endif
								</div>
							@endif

							<div class="btn-group">
								<a href="{{ URL::to('admin/user/edit/'.$user->id) }}" class="btn btn-sm btn-default icn-size-16">{{ $_icons['edit'] }}</a>
							</div>
						@endif

						@if ($_currentUser->hasAccess('user.delete'))
							<div class="btn-group">
								<a href="#" class="btn btn-sm btn-danger js-user-action icn-size-16" data-action="delete" data-id="{{ $user->id }}">{{ $_icons['remove'] }}</a>
							</div>
						@endif
					</div>
				</div>
				<div class="hidden-lg">
					<div class="row">
						@if ($_currentUser->canEditUser($user))
							@if ($_currentUser->hasLevel('user.update', 2))
								@if ($user->status == Status::ACTIVE)
									<div class="col-xs-12 col-sm-4">
										<p><a href="#" class="btn btn-lg btn-block btn-default icn-size-16">{{ $_icons['reject'] }}</a></p>
									</div>
								@endif

								@if ($user->status == Status::INACTIVE)
									<div class="col-xs-12 col-sm-4">
										<p><a href="#" class="btn btn-lg btn-block btn-default icn-size-16">{{ $_icons['check'] }}</a></p>
									</div>
								@endif
							@endif

							<div class="col-xs-12 col-sm-4">
								<p><a href="{{ URL::to('admin/user/edit/'.$user->id) }}" class="btn btn-lg btn-block btn-default icn-size-16">{{ $_icons['edit'] }}</a></p>
							</div>
						@endif

						@if ($_currentUser->hasAccess('user.delete'))
							<div class="col-xs-12 col-sm-4">
								<p><a href="#" class="btn btn-lg btn-block btn-danger js-user-action icn-size-16" data-action="delete" data-id="{{ $user->id }}">{{ $_icons['remove'] }}</a></p>
							</div>
						@endif
					</div>
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

{{ modal(['id' => 'deleteUser', 'header' => lang('Short.delete', lang('User'))]) }}