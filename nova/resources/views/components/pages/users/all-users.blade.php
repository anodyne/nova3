<h1>{{ _m('users', [2]) }}</h1>

@if ($users->count() > 0)
	<div class="alert alert-info" v-show="status == '{{ Status::REMOVED }}'">
		<p>{{ _m('users-deleted-notice') }}</p>
	</div>

	<div class="data-table bordered striped">
		<div class="row header align-items-start align-items-md-center">
			<div class="col">
				<mobile>
					<div v-show="!mobileFilter && !mobileSearch">
						<a href="#" class="btn btn-secondary" @click.prevent="mobileFilter = true">{!! icon('filter') !!}</a>
						<a href="#" class="btn btn-secondary" @click.prevent="mobileSearch = true">{!! icon('search') !!}</a>
					</div>

					<div v-show="mobileFilter">
						<select name="" class="custom-select" v-model="status" v-show="mobileFilter" @change="mobileFilter = false">
							<option value="">{{ _m('users-status-all') }}</option>
							<option value="{{ Status::ACTIVE }}">{{ _m('users-status-active') }}</option>
							<option value="{{ Status::INACTIVE }}">{{ _m('users-status-inactive') }}</option>
							<option value="{{ Status::REMOVED }}">{{ _m('users-status-removed') }}</option>
						</select>
					</div>

					<div class="input-group" v-show="mobileSearch">
						<input type="text"
							   class="form-control"
							   placeholder="{{ _m('users-find') }}"
							   v-model="search">
						<span class="input-group-btn">
							<a class="btn btn-secondary" href="#" @click.prevent="resetSearch">
								{!! icon('close') !!}
							</a>
						</span>
					</div>
				</mobile>
				<desktop>
					<div class="input-group">
						<input type="text"
							   class="form-control"
							   placeholder="{{ _m('users-find') }}"
							   v-model="search">
						<span class="input-group-btn">
							<a class="btn btn-secondary" href="#" @click.prevent="resetSearch">
								{!! icon('close') !!}
							</a>
						</span>
					</div>
				</desktop>
			</div>
			<div class="col d-none d-lg-block">
				<desktop>
					<select name="" class="custom-select" v-model="status">
						<option value="">{{ _m('users-status-all') }}</option>
						<option value="{{ Status::ACTIVE }}">{{ _m('users-status-active') }}</option>
						<option value="{{ Status::INACTIVE }}">{{ _m('users-status-inactive') }}</option>
						<option value="{{ Status::REMOVED }}">{{ _m('users-status-removed') }}</option>
					</select>
				</desktop>
			</div>
			<div class="col col-auto" v-show="!mobileSearch">
				<a class="btn btn-secondary" href="#" @click.prevent="mobileFilter = false" v-show="mobileFilter">
					{!! icon('close') !!}
				</a>

				@can('create', $userClass)
					<div class="btn-toolbar" v-show="!mobileFilter">
						<a href="{{ route('users.create') }}" class="btn btn-success">{!! icon('add') !!}</a>

						@can('update', $userClass)
							<div class="dropdown ml-2">
								<button type="button"
	  									class="btn btn-secondary btn-action"
	  									data-toggle="dropdown"
	  									aria-haspopup="true"
	  									aria-expanded="false">
									{!! icon('more') !!}
								</button>

								<div class="dropdown-menu dropdown-menu-right">
									<a href="{{ route('users.force-password-reset') }}" class="dropdown-item">
										{!! icon('users') !!} {{ _m('users-password-reset') }}
									</a>

									@can('update', $characterClass)
										<a href="{{ route('characters.link') }}" class="dropdown-item">{!! icon('link') !!} {{ _m('characters-link') }}</a>
									@endcan
								</div>
							</div>
						@endcan
					</div>
				@endcan

				@cannot('create', $userClass)
					@can('update', $userClass)
						<a href="{{ route('users.force-password-reset') }}" class="btn btn-secondary">
							{!! icon('users') !!}
						</a>
					@endcan
				@endcannot
			</div>
		</div>

		<div class="row align-items-center" v-for="user in filteredUsers">
			<div class="col">
				<avatar :item="user"
						size="sm"
						type="link">
					<span class="text-muted" v-if="showCharacters && usersCharacters(user).length > 0">
						<strong>{{ _m('users-assigned-characters') }}:</strong>
						@{{ usersCharacters(user) }}
					</span>
				</avatar>
			</div>
			<div class="col col-auto">
				<div class="dropdown">
					<button class="btn btn-secondary btn-action"
							type="button"
							id="dropdownMenuButton"
							data-toggle="dropdown"
							aria-haspopup="true"
							aria-expanded="false">
						{!! icon('more') !!}
					</button>
					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
						<a :href="profileLink(user.id)" class="dropdown-item">
							{!! icon('user') !!} {{ _m('users-profile') }}
						</a>

						@can('manage', $userClass)
							<div class="dropdown-divider"></div>
						@endcan

						@can('update', $userClass)
							<a :href="editLink(user.id)" class="dropdown-item">{!! icon('edit') !!} {{ _m('edit') }}</a>
						@endcan

						@can('delete', $userClass)
							<a href="#"
							   class="dropdown-item text-danger"
							   @click.prevent="deleteUser(user.id)"
							   v-show="!isTrashed(user)">
								{!! icon('delete') !!} {{ _m('delete') }}
							</a>
						@endcan

						@can('update', $userClass)
							<a href="#"
							   class="dropdown-item text-success"
							   @click.prevent="restoreUser(user.id)"
							   v-show="isTrashed(user)">
								{!! icon('undo') !!} {{ _m('restore') }}
							</a>

							<div class="dropdown-divider"></div>

							<a href="#"
							   class="dropdown-item text-warning"
							   @click.prevent="deactivateUser(user.id)"
							   v-show="isActive(user)">
								{!! icon('close-alt') !!} {{ _m('deactivate') }}
							</a>

							<a href="#"
							   class="dropdown-item text-success"
							   @click.prevent="activateUser(user.id)"
							   v-show="isInactive(user)">
								{!! icon('check-alt') !!} {{ _m('activate') }}
							</a>

							<a href="#"
							   class="dropdown-item text-success"
							   @click.prevent="activateUser(user.id)"
							   v-show="isPending(user)">
								{!! icon('user-alt') !!} {{ _m('activate') }}
							</a>
						@endcan
					</div>
				</div>
			</div>
		</div>
	</div>
@else
	<div class="alert alert-warning">
		{{ _m('users-error-not-found') }} <a href="{{ route('users.create') }}" class="alert-link">{{ _m('users-error-add') }}</a>
	</div>
@endif