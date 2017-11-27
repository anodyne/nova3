@extends('layouts.app')

@section('title', _m('genre-ranks', [2]))

@section('content')
	<h1>{{ _m('genre-ranks', [2]) }}</h1>

	<div class="data-table bordered striped" id="sortable">
		<div class="row header">
			<div class="col">
				<mobile>
					<div v-show="mobileFilter || group == ''">
						{!! Form::select(null, $groups, null, ['class' => 'custom-select', 'v-model' => 'group', 'placeholder' => _m('genre-rank-groups-select'), '@change' => 'mobileFilter = false']) !!}
					</div>

					<div class="input-group" v-show="mobileSearch">
						<input type="text" class="form-control" placeholder="{{ _m('genre-ranks-find') }}" v-model="search">
						<span class="input-group-btn">
							<a class="btn btn-secondary" href="#" @click.prevent="resetSearch">{!! icon('close') !!}</a>
						</span>
					</div>

					<a href="#"
					   class="btn btn-secondary"
					   @click.prevent="mobileFilter = true"
					   v-show="!mobileFilter && !mobileSearch && group != ''">{!! icon('filter') !!}</a>

					<a href="#"
					   class="btn btn-secondary"
					   @click.prevent="mobileSearch = true"
					   v-show="!mobileFilter && !mobileSearch && group != ''">{!! icon('search') !!}</a>
				</mobile>
				<desktop>
					<div class="input-group">
						<input type="text" class="form-control" placeholder="{{ _m('genre-ranks-find') }}" v-model="search">
						<span class="input-group-btn">
							<a class="btn btn-secondary" href="#" @click.prevent="resetSearch">{!! icon('close') !!}</a>
						</span>
					</div>
				</desktop>
			</div>
			<div class="col d-none d-lg-block">
				{!! Form::select(null, $groups, null, ['class' => 'custom-select', 'v-model' => 'group', 'placeholder' => _m('genre-rank-groups-select')]) !!}
			</div>
			<div class="col col-auto" v-show="!mobileSearch">
				<mobile>
					<a href="#"
					   class="btn btn-secondary"
					   @click.prevent="mobileFilter = false"
					   v-show="mobileFilter && group != ''">{!! icon('close') !!}</a>
				</mobile>

				<div class="btn-toolbar" v-show="!mobileFilter">
					@can('create', $rankClass)
						<a href="{{ route('ranks.items.create') }}" class="btn btn-success">{!! icon('add') !!}</a>
					@endcan

					@can('manage', $rankClass)
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
								<a href="{{ route('ranks.info.index') }}" class="dropdown-item">{!! icon('info') !!} {{ _m('genre-rank-info') }}</a>
							</div>
						</div>
					@endcan
				</div>
			</div>
		</div>
		<div class="row" v-if="group == ''">
			<div class="col">
				<div class="alert alert-info mb-0">
					{{ _m('genre-ranks-start') }}
				</div>
			</div>
		</div>
		<div class="row" v-if="group != '' && filteredRanks().length == 0">
			<div class="col">
				<div class="alert alert-warning mb-0">
					{{ _m('genre-ranks-error-not-found-group') }}
				</div>
			</div>
		</div>

		<div class="row align-items-start draggable-item"
			 :data-id="rank.id"
			 v-if="group != '' && filteredRanks().length > 0"
			 v-for="rank in filteredRanks()">
			<desktop>
				<div class="col col-auto">
					<span class="sortable-handle text-subtle">{!! icon('reorder') !!}</span>
				</div>
			</desktop>
			<div class="col d-flex align-items-center">
				<rank :item="rank"></rank>
				<div class="ml-3">@{{ rank.info.name }}</div>
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
						@can('create', $rankClass)
							<a href="#" class="dropdown-item" @click.prevent="duplicateRank(rank.id)">
								{!! icon('copy') !!} {{ _m('duplicate') }}
							</a>
						@endcan

						@can('update', $rankClass)
							<a :href="editLink(rank.id)" class="dropdown-item">{!! icon('edit') !!} {{ _m('edit') }}</a>
						@endcan

						@can('delete', $rankClass)
							<a href="#" class="dropdown-item text-danger" @click.prevent="deleteRank(rank.id)">{!! icon('delete') !!} {{ _m('delete') }}</a>
						@endcan
					</div>
				</div>

				<mobile>
					<div class="btn btn-block btn-secondary sortable-handle mt-3">{!! icon('reorder') !!}</div>
				</mobile>
			</div>
		</div>
	</div>
@endsection

@section('js')
	<script>
		vue = {
			data: {
				group: '',
				ranks: {!! $ranks !!},
				mobileFilter: false,
				mobileSearch: false,
				search: ''
			},

			methods: {
				deleteRank (id) {
					let self = this

					$.confirm({
						title: "{{ _m('genre-ranks-confirm-delete-title') }}",
						content: "{{ _m('genre-ranks-confirm-delete-message') }}",
						columnClass: "medium",
						theme: "dark",
						buttons: {
							confirm: {
								text: "{{ _m('delete') }}",
								btnClass: "btn-danger",
								action () {
									axios.delete(route('ranks.items.destroy', {item:id}))
										.then(function (response) {
											let index = _.findIndex(self.ranks, function (r) {
												return r.id == id
											})

											self.ranks.splice(index, 1)

											flash(
												'{{ _m('genre-ranks-flash-deleted-message') }}',
												'{{ _m('genre-ranks-flash-deleted-title') }}'
											)
										})
								}
							},
							cancel: {
								text: "{{ _m('cancel') }}"
							}
						}
					})
				},

				duplicateRank (id) {
					axios.post(route('ranks.items.duplicate', {item:id}))

					window.setTimeout(function () {
						window.location.replace(route('ranks.items.index'))
					}, 1000)
				},

				editLink (id) {
					return route('ranks.items.edit', {item:id})
				},

				filteredRanks () {
					let self = this
					let filteredRanks = this.ranks.filter(function (rank) {
						return rank.group_id == self.group
					})

					return filteredRanks.filter(function (rank) {
						let searchRegex = new RegExp(self.search, 'i')

						return searchRegex.test(rank.info.name) || searchRegex.test(rank.info.short_name)
					})
				},

				resetSearch () {
					this.search = ''
					this.mobileSearch = false
				}
			},

			mounted () {
				Sortable.create(document.getElementById('sortable'), {
					draggable: '.draggable-item',
					handle: '.sortable-handle',
					onEnd (event) {
						let order = new Array()

						$(event.from).children().each(function () {
							let id = $(this).data('id')

							if (id) {
								order.push(id)
							}
						})

						axios.patch(route('ranks.items.reorder'), {
							items: order
						})
					}
				})
			}
		}
	</script>
@endsection