<h1>{{ _m('genre-rank-info') }}</h1>

@if ($info->count() > 0)
	<div class="data-table bordered striped" id="sortable">
		<div class="row header">
			<div class="col">
				<mobile>
					<a href="#"
					   class="btn btn-secondary btn-action"
					   v-show="!mobileSearch"
					   @click.prevent="mobileSearch = true">{!! icon('search') !!}</a>

					<div class="input-group" v-show="mobileSearch">
						<input type="text" class="form-control" placeholder="{{ _m('genre-rank-info-find') }}" v-model="search">
						<span class="input-group-btn">
							<a class="btn btn-secondary" href="#" @click.prevent="resetSearch">{!! icon('close') !!}</a>
						</span>
					</div>
				</mobile>
				<desktop>
					<div class="input-group">
						<input type="text" class="form-control" placeholder="{{ _m('genre-rank-info-find') }}" v-model="search">
						<span class="input-group-btn">
							<a class="btn btn-secondary" href="#" @click.prevent="resetSearch">{!! icon('close') !!}</a>
						</span>
					</div>
				</desktop>
			</div>
			<div class="col d-none d-lg-block"></div>
			<div class="col col-auto" v-show="!mobileSearch">
				<div class="btn-toolbar">
					@can('create', $rankInfoClass)
						<a href="{{ route('ranks.info.create') }}" class="btn btn-success">{!! icon('add') !!}</a>
					@endcan

					@can('update', $rankInfoClass)
						<a href="#"
						   class="btn btn-primary ml-2"
						   @click.prevent="updateInfo"
						   v-if="filteredInfo.length > 0">{!! icon('check') !!}</a>
					@endcan

					@can('manage', $rankInfoClass)
						<div class="dropdown ml-2">
							<button type="button"
  									class="btn btn-secondary btn-action"
  									data-toggle="dropdown"
  									aria-haspopup="true"
  									aria-expanded="false">
								{!! icon('more') !!}
							</button>

							<div class="dropdown-menu dropdown-menu-right">
								<a href="{{ route('ranks.groups.index') }}" class="dropdown-item">{!! icon('list') !!} {{ _m('genre-rank-groups', [2]) }}</a>
								<a href="{{ route('ranks.items.index') }}" class="dropdown-item">{!! icon('star') !!} {{ _m('genre-ranks', [2]) }}</a>
							</div>
						</div>
					@endcan
				</div>
			</div>
		</div>
		<div class="row" v-if="filteredInfo.length == 0">
			<div class="col">
				<div class="alert alert-warning mb-0">
					{{ _m('genre-rank-info-error-not-found') }}
				</div>
			</div>
		</div>

		<div class="row align-items-start draggable-item"
			 :data-id="info.id"
			 v-for="(info, index) in filteredInfo">
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
							<input type="text" class="form-control" v-model="info.name">
						</div>
					</div>
					<div class="col-md-6">
						<div :class="formGroupClasses('short_name', index)">
							<label>{{ _m('genre-rank-info-short_name') }}</label>
							<input type="text" class="form-control" v-model="info.short_name">
						</div>
					</div>
				</div>
			</div>
			<div class="col col-auto">
				@can('delete', $rankInfoClass)
					<a class="btn btn-action btn-danger mb-4" href="#" @click.prevent="deleteInfo(info.id)">
						{!! icon('delete') !!}
					</a>
				@endcan
				<mobile>
					<div class="btn btn-block btn-secondary sortable-handle">{!! icon('reorder') !!}</div>
				</mobile>
			</div>
		</div>
	</div>
@else
	<div class="alert alert-warning">
		{{ _m('genre-rank-info-error-not-found') }} <a href="{{ route('ranks.info.create') }}" class="alert-link">{{ _m('genre-rank-info-error-add') }}</a>
	</div>
@endif

<div class="alert alert-warning dirty d-flex align-items-center" v-if="dirtyInfo">
	{{ _m('genre-rank-info-unsaved') }} <a href="#" class="alert-btn" @click.prevent="updateInfo">{{ _m('save-now') }}</a>
</div>