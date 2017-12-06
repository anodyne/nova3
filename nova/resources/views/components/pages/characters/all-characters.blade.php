<h1>{{ _m('characters', [2]) }}</h1>

@if ($characters->count() > 0)
	<div class="alert alert-info" v-show="status == '{{ Status::REMOVED }}'">
		<p>{{ _m('characters-deleted-notice') }}</p>
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
				</mobile>
				<desktop>
					<div class="input-group">
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
				</desktop>
			</div>
			<div class="col d-none d-lg-block">
				<select name="" class="custom-select" v-model="status">
					<option value="">{{ _m('characters-status-all') }}</option>
					<option value="{{ Status::ACTIVE }}">{{ _m('characters-status-active') }}</option>
					<option value="{{ Status::INACTIVE }}">{{ _m('characters-status-inactive') }}</option>
					<option value="{{ Status::REMOVED }}">{{ _m('characters-status-removed') }}</option>
				</select>
			</div>
			<div class="col col-auto" v-show="!mobileSearch">
				<a class="btn btn-secondary" href="#" @click.prevent="mobileFilter = false" v-show="mobileFilter">
					{!! icon('close') !!}
				</a>

				<div class="btn-toolbar" v-show="!mobileFilter">
					@can('create', $characterClass)
						<div class="btn-toolbar">
							<a href="{{ route('characters.create') }}" class="btn btn-success">{!! icon('add') !!}</a>
						</div>
					@endcan

					@can('update', $characterClass)
						<div class="dropdown ml-2">
							<button type="button"
  									class="btn btn-secondary btn-action"
  									data-toggle="dropdown"
  									aria-haspopup="true"
  									aria-expanded="false">
								{!! icon('more') !!}
							</button>

							<div class="dropdown-menu dropdown-menu-right">
								<a href="{{ route('characters.link') }}" class="dropdown-item">{!! icon('link') !!} {{ _m('characters-link') }}</a>
							</div>
						</div>
					@endcan
				</div>
			</div>
		</div>

		<div class="row align-items-center" v-for="character in filteredCharacters">
			<div class="col col-auto d-none d-lg-block">
				<rank :item="character.rank"></rank>
			</div>
			<div class="col">
				<avatar :item="character" type="image"></avatar>
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
						<a :href="bioLink(character.id)" class="dropdown-item">
							{!! icon('user') !!} {{ _m('characters-bio') }}
						</a>

						@can('manage', $characterClass)
							<div class="dropdown-divider"></div>
						@endcan

						@can('update', $characterClass)
							<a :href="editLink(character.id)" class="dropdown-item">{!! icon('edit') !!} {{ _m('edit') }}</a>
						@endcan

						@can('delete', $characterClass)
							<a href="#"
							   class="dropdown-item text-danger"
							   @click.prevent="deleteCharacter(character.id)"
							   v-show="!isTrashed(character)">
								{!! icon('delete') !!} {{ _m('delete') }}
							</a>
						@endcan

						@can('update', $characterClass)
							<a href="#"
							   class="dropdown-item text-success"
							   @click.prevent="restoreCharacter(character.id)"
							   v-show="isTrashed(character)">
								{!! icon('undo') !!} {{ _m('restore') }}
							</a>

							<div class="dropdown-divider"></div>

							<a href="#"
							   class="dropdown-item text-success"
							   @click.prevent="activateCharacter(character.id)"
							   v-show="isInactive(character)">
								{!! icon('check-alt') !!} {{ _m('activate') }}
							</a>

							<a href="#"
							   class="dropdown-item text-warning"
							   @click.prevent="deactivateCharacter(character.id)"
							   v-show="isActive(character)">
								{!! icon('close-alt') !!} {{ _m('deactivate') }}
							</a>

							<a href="#"
							   class="dropdown-item"
							   @click.prevent="deactivateCharacter(character.id)"
							   v-show="isPending(character)">
								{!! icon('user-alt') !!} {{ _m('deactivate') }}
							</a>
						@endcan
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