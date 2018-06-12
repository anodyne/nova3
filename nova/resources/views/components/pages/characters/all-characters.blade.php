<h1>{{ _m('characters', [2]) }}</h1>

@if ($characters->count() > 0)
	<div class="alert alert-info" v-show="status == '{{ Status::REMOVED }}'">
		<p>{{ _m('characters-deleted-notice') }}</p>
	</div>

	<div class="data-table is-bordered is-striped is-rounded">
		<div class="row is-header">
			<div class="col">
				<mobile-view>
					<div v-show="!mobileFilter && !mobileSearch">
						<a href="#" class="btn btn-secondary" @click.prevent="mobileFilter = true">{!! icon('filter') !!}</a>
						<a href="#" class="btn btn-secondary" @click.prevent="mobileSearch = true">{!! icon('search') !!}</a>
					</div>

					<div v-show="mobileFilter">
						<select name="" class="custom-select" v-model="status" v-show="mobileFilter" @change="mobileFilter = false">
							<option value="">{{ _m('characters-status-all') }}</option>
							<option value="{{ Status::ACTIVE }}">{{ _m('characters-status-active') }}</option>
							<option value="{{ Status::INACTIVE }}">{{ _m('characters-status-inactive') }}</option>
							<option value="{{ Status::REMOVED }}">{{ _m('characters-status-removed') }}</option>
						</select>
					</div>

					<div class="input-group" v-show="mobileSearch">
						<input type="text"
							   class="form-control"
							   placeholder="{{ _m('characters-find') }}"
							   v-model="search">
						<span class="input-group-btn">
							<a class="btn btn-secondary" href="#" @click.prevent="resetSearch">
								{!! icon('close') !!}
							</a>
						</span>
					</div>
				</mobile-view>
				<desktop-view>
					<text-input placeholder="{{ _m('characters-find') }}" v-model="search">
						<template slot="field-addon-after">
							<a href="#" class="leading-0" @click.prevent="resetSearch">
								<icon name="close" />
							</a>
						</template>
					</text-input>
				</desktop-view>
			</div>
			<div class="col">
				<select name="" class="custom-select" v-model="status">
					<option value="">{{ _m('characters-status-all') }}</option>
					<option value="{{ Status::ACTIVE }}">{{ _m('characters-status-active') }}</option>
					<option value="{{ Status::INACTIVE }}">{{ _m('characters-status-inactive') }}</option>
					<option value="{{ Status::REMOVED }}">{{ _m('characters-status-removed') }}</option>
				</select>
			</div>
			<div class="col-auto" v-show="!mobileSearch">
				<a class="button is-secondary" href="#" @click.prevent="mobileFilter = false" v-show="mobileFilter">
					{!! icon('close') !!}
				</a>

				<div v-show="!mobileFilter">
					@can('create', $characterClass)
						<a href="{{ route('characters.create') }}" class="button is-success">{!! icon('add') !!}</a>
					@endcan

					@can('update', $characterClass)
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
									<a href="{{ route('characters.link') }}" class="dropdown-item">
										<icon name="link" :wrapper="{ class:'dropdown-icon' }"></icon>
										{{ _m('characters-link') }}
									</a>
								</div>
							</div>
						</div>
					@endcan
				</div>
			</div>
		</div>

		<div class="row" v-for="character in filteredCharacters">
			<div class="col-auto">
				<rank :item="character.rank"></rank>
			</div>
			<div class="col">
				<avatar :item="character" type="image"></avatar>
			</div>
			<div class="col-auto">
				<div class="dropdown is-right">
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
							<a :href="bioLink(character.id)" class="dropdown-item">
								<icon name="user" :wrapper="{ class:'dropdown-icon' }"></icon>
								{{ _m('characters-bio') }}
							</a>

							@can('manage', $characterClass)
								<div class="dropdown-divider"></div>
							@endcan

							@can('update', $characterClass)
								<a :href="editLink(character.id)" class="dropdown-item">
									<icon name="edit" :wrapper="{ class:'dropdown-icon' }"></icon>
									{{ _m('edit') }}
								</a>
							@endcan

							@can('delete', $characterClass)
								<a href="#"
								   class="dropdown-item text-danger"
								   @click.prevent="deleteCharacter(character.id)"
								   v-show="!isTrashed(character)">
									<icon name="delete" :wrapper="{ class:'dropdown-icon' }"></icon>
									{{ _m('delete') }}
								</a>
							@endcan

							@can('update', $characterClass)
								<a href="#"
								   class="dropdown-item text-success"
								   @click.prevent="restoreCharacter(character.id)"
								   v-show="isTrashed(character)">
									<icon name="undo" :wrapper="{ class:'dropdown-icon' }"></icon>
									{{ _m('restore') }}
								</a>

								<div class="dropdown-divider"></div>

								<a href="#"
								   class="dropdown-item text-success"
								   @click.prevent="activateCharacter(character.id)"
								   v-show="isInactive(character)">
									<icon name="check-alt" :wrapper="{ class:'dropdown-icon' }"></icon>
									{{ _m('activate') }}
								</a>

								<a href="#"
								   class="dropdown-item text-warning-dark"
								   @click.prevent="deactivateCharacter(character.id)"
								   v-show="isActive(character)">
									<icon name="close-alt" :wrapper="{ class:'dropdown-icon' }"></icon>
									{{ _m('deactivate') }}
								</a>

								<a href="#"
								   class="dropdown-item"
								   @click.prevent="deactivateCharacter(character.id)"
								   v-show="isPending(character)">
									<icon name="user-alt" :wrapper="{ class:'dropdown-icon' }"></icon>
									{{ _m('deactivate') }}
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
		{{ _m('characters-error-not-found') }} <a href="{{ route('characters.create') }}" class="alert-link">{{ _m('characters-error-add') }}</a>
	</div>
@endif
