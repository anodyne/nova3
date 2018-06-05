<h1>{{ _m('users', [2]) }}</h1>

@if ($users->count() > 0)
	<div class="alert alert-info" v-show="status == '{{ Status::REMOVED }}'">
		<p>{{ _m('users-deleted-notice') }}</p>
	</div>

	<div class="data-table is-bordered is-striped">
		<div class="row is-header">
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
					<text-input placeholder="{{ _m('users-find') }}" v-model="search">
						<template slot="field-addon-after">
							<a href="#" class="leading-0" @click.prevent="resetSearch">
								<icon name="close" />
							</a>
						</template>
					</text-input>
				</desktop>
			</div>
			<div class="col">
				<desktop>
					<select name="" class="custom-select" v-model="status">
						<option value="">{{ _m('users-status-all') }}</option>
						<option value="{{ Status::ACTIVE }}">{{ _m('users-status-active') }}</option>
						<option value="{{ Status::INACTIVE }}">{{ _m('users-status-inactive') }}</option>
						<option value="{{ Status::REMOVED }}">{{ _m('users-status-removed') }}</option>
					</select>
				</desktop>
			</div>
			<div class="col-auto" v-show="!mobileSearch">
				<a class="btn btn-secondary" href="#" @click.prevent="mobileFilter = false" v-show="mobileFilter">
					{!! icon('close') !!}
				</a>

				@can('create', $userClass)
					<div v-show="!mobileFilter">
						<a href="{{ route('users.create') }}" class="button is-success">{!! icon('add') !!}</a>

						@can('update', $userClass)
							<div class="dropdown is-right ml-2">
								<div class="dropdown-trigger">
									<button type="button"
		  									class="button is-secondary btn-action"
		  									data-toggle="dropdown"
		  									aria-haspopup="true"
		  									aria-expanded="false">
										<icon name="more" />
									</button>
								</div>

								<div class="dropdown-menu">
									<div class="dropdown-content">
										<a href="{{ route('users.force-password-reset') }}" class="dropdown-item">
											<icon name="users" :wrapper="{ class:'dropdown-icon' }"></icon>
											{{ _m('users-password-reset') }}
										</a>

										@can('update', $characterClass)
											<a href="{{ route('characters.link') }}" class="dropdown-item">
												<icon name="link" :wrapper="{ class:'dropdown-icon' }"></icon>
												{{ _m('characters-link') }}
											</a>
										@endcan
									</div>
								</div>
							</div>
						@endcan
					</div>
				@endcan

				@cannot('create', $userClass)
					@can('update', $userClass)
						<a href="{{ route('users.force-password-reset') }}" class="button is-secondary">
							{!! icon('users') !!}
						</a>
					@endcan
				@endcannot
			</div>
		</div>

		<div class="row items-center" v-for="user in filteredUsers">
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
			<div class="col-auto">
				<div class="dropdown is-right ml-2">
					<div class="dropdown-trigger">
						<button type="button"
								class="button is-secondary btn-action"
								data-toggle="dropdown"
								aria-haspopup="true"
								aria-expanded="false">
							<icon name="more" />
						</button>
					</div>

					<div class="dropdown-menu">
						<div class="dropdown-content">
							<a :href="profileLink(user.id)" class="dropdown-item">
								<icon name="user" :wrapper="{ class:'dropdown-icon' }"></icon>
								{{ _m('users-profile') }}
							</a>

							@can('manage', $userClass)
								<div class="dropdown-divider"></div>
							@endcan

							@can('update', $userClass)
								<a :href="editLink(user.id)" class="dropdown-item">
									<icon name="edit" :wrapper="{ class:'dropdown-icon' }"></icon>
									{{ _m('edit') }}
								</a>
							@endcan

							@can('delete', $userClass)
								<a href="#"
								   class="dropdown-item text-danger"
								   @click.prevent="deleteUser(user.id)"
								   v-show="!isTrashed(user)">
									<icon name="delete" :wrapper="{ class:'dropdown-icon' }"></icon>
									{{ _m('delete') }}
								</a>
							@endcan

							@can('update', $userClass)
								<a href="#"
								   class="dropdown-item text-success"
								   @click.prevent="restoreUser(user.id)"
								   v-show="isTrashed(user)">
									<icon name="undo" :wrapper="{ class:'dropdown-icon' }"></icon>
									{{ _m('restore') }}
								</a>

								<div class="dropdown-divider"></div>

								<a href="#"
								   class="dropdown-item text-warning-dark"
								   @click.prevent="deactivateUser(user.id)"
								   v-show="isActive(user)">
									<icon name="close-alt" :wrapper="{ class:'dropdown-icon' }"></icon>
									{{ _m('deactivate') }}
								</a>

								<a href="#"
								   class="dropdown-item text-success"
								   @click.prevent="activateUser(user.id)"
								   v-show="isInactive(user)">
									<icon name="check-alt" :wrapper="{ class:'dropdown-icon' }"></icon>
									{{ _m('activate') }}
								</a>

								<a href="#"
								   class="dropdown-item text-success"
								   @click.prevent="activateUser(user.id)"
								   v-show="isPending(user)">
									<icon name="user-alt" :wrapper="{ class:'dropdown-icon' }"></icon>
									{{ _m('activate') }}
								</a>
							@endcan
						</div>
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