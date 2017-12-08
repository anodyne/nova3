<h1>{{ _m('genre-rank-groups', [2]) }}</h1>

@if ($rankGroups->count() > 0)
	<div class="data-table bordered striped" id="sortable">
		<div class="row header">
			<div class="col">
				<mobile>
					<a href="#"
					   class="btn btn-secondary btn-action"
					   v-show="!mobileSearch"
					   @click.prevent="mobileSearch = true">{!! icon('search') !!}</a>

					<div class="input-group" v-show="mobileSearch">
						<input type="text" class="form-control" placeholder="{{ _m('genre-rank-groups-find') }}" v-model="search">
						<span class="input-group-btn">
							<a class="btn btn-secondary" href="#" @click.prevent="resetSearch">{!! icon('close') !!}</a>
						</span>
					</div>
				</mobile>
				<desktop>
					<div class="input-group">
						<input type="text" class="form-control" placeholder="{{ _m('genre-rank-groups-find') }}" v-model="search">
						<span class="input-group-btn">
							<a class="btn btn-secondary" href="#" @click.prevent="resetSearch">{!! icon('close') !!}</a>
						</span>
					</div>
				</desktop>
			</div>
			<div class="col d-none d-lg-block"></div>
			<div class="col col-auto" v-show="!mobileSearch">
				<div class="btn-toolbar">
					@can('create', $rankGroupClass)
						<a href="{{ route('ranks.groups.create') }}" class="btn btn-success">{!! icon('add') !!}</a>
					@endcan

					@can('update', $rankGroupClass)
						<a href="#"
						   class="btn btn-primary ml-2"
						   @click.prevent="updateGroups">{!! icon('check') !!}</a>
					@endcan

					@can('manage', $rankGroupClass)
						<div class="dropdown ml-2">
							<button type="button"
  									class="btn btn-secondary btn-action"
  									data-toggle="dropdown"
  									aria-haspopup="true"
  									aria-expanded="false">
								{!! icon('more') !!}
							</button>

							<div class="dropdown-menu dropdown-menu-right">
								<a href="{{ route('ranks.info.index') }}" class="dropdown-item">{!! icon('info') !!} {{ _m('genre-rank-info') }}</a>
								<a href="{{ route('ranks.items.index') }}" class="dropdown-item">{!! icon('star') !!} {{ _m('genre-ranks', [2]) }}</a>
							</div>
						</div>
					@endcan
				</div>
			</div>
		</div>

		<div class="row align-items-start draggable-item"
			 :data-id="group.id"
			 v-for="(group, index) in filteredGroups">
			<desktop>
				<div class="col col-auto">
					<span class="sortable-handle text-subtle">{!! icon('reorder') !!}</span>
				</div>
			</desktop>
			<div class="col">
				<div class="row">
					<div class="col-md-6">
						<div :class="formGroupClasses('name', index)">
							<label>{{ _m('name') }}</label>
							<input type="text" class="form-control" v-model="group.name">
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label>{{ _m('displayed') }}</label>
							<div>
								<toggle-button class="toggle-switch lg"
											   :value="group.display == 1"
											   :data-group="group.id"
											   @change="toggleDisplay"></toggle-button>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col col-auto">
				<div class="dropdown">
					<button class="btn btn-secondary btn-action mb-4"
							type="button"
							id="dropdownMenuButton"
							data-toggle="dropdown"
							aria-haspopup="true"
							aria-expanded="false">
						{!! icon('more') !!}
					</button>
					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
						@can('create', $rankGroupClass)
							<a class="dropdown-item" href="#" @click.prevent="duplicateGroup(group.id)">
								{!! icon('copy') !!} {{ _m('duplicate') }}
							</a>
						@endcan

						@can('delete', $rankGroupClass)
							<a class="dropdown-item text-danger" href="#" @click.prevent="deleteGroup(group.id)">
								{!! icon('delete') !!} {{ _m('delete') }}
							</a>
						@endcan
					</div>

					<mobile>
						<div class="btn btn-block btn-secondary sortable-handle">{!! icon('reorder') !!}</div>
					</mobile>
				</div>
			</div>
		</div>
	</div>
@else
	<div class="alert alert-warning">
		{{ _m('genre-rank-groups-error-not-found') }} <a href="{{ route('ranks.groups.create') }}" class="alert-link">{{ _m('genre-rank-groups-error-add') }}</a>
	</div>
@endif

<div class="alert alert-warning dirty d-flex align-items-center" v-if="dirtyGroups">
	{{ _m('genre-rank-groups-unsaved') }} <a href="#" class="alert-btn" @click.prevent="updateGroups">{{ _m('save-now') }}</a>
</div>