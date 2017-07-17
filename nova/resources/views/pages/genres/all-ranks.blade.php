@extends('layouts.app')

@section('title', _m('genre-ranks'))

@section('content')
	<h1>{{ _m('genre-ranks') }}</h1>

	<div class="data-table bordered striped" id="sortable">
		<div class="row header">
			<div class="col-8 col-md-5">
				<div class="input-group">
					<input type="text" class="form-control" placeholder="{{ _m('genre-rank-find') }}" v-model="search">
					<span class="input-group-btn">
						<a class="btn btn-secondary" href="#" @click.prevent="search = ''">{!! icon('close') !!}</a>
					</span>
				</div>
				<div class="mt-2 hidden-md-up">
					{!! Form::select(null, $groups, null, ['class' => 'custom-select', 'v-model' => 'group', 'placeholder' => _m('genre-rank-groups-select')]) !!}
				</div>
			</div>
			<div class="col hidden-sm-down">
				{!! Form::select(null, $groups, null, ['class' => 'custom-select', 'v-model' => 'group', 'placeholder' => _m('genre-rank-groups-select')]) !!}
			</div>
			<div class="col col-xs-auto">
				<div class="btn-toolbar pull-right">
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
								<a href="{{ route('ranks.groups.index') }}" class="dropdown-item">{!! icon('list') !!} {{ _m('genre-rank-groups') }}</a>
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
					{{ _m('genre-rank-start') }}
				</div>
			</div>
		</div>
		<div class="row" v-if="group != '' && filteredRanks().length == 0">
			<div class="col">
				<div class="alert alert-warning mb-0">
					{{ _m('genre-rank-error-not-found-group') }}
				</div>
			</div>
		</div>
		<div class="row align-items-start"
			 :data-id="rank.id"
			 v-if="group != '' && filteredRanks().length > 0"
			 v-for="rank in filteredRanks()">
			<div class="col col-auto">
				<span class="sortable-handle text-subtle">{!! icon('reorder') !!}</span>
			</div>
			<div class="col-9 d-flex align-items-center">
				<rank :item="rank"></rank>
				<div class="ml-3">@{{ rank.info.name }}</div>
			</div>
			<div class="col col-xs-auto"></div>
		</div>
	</div>
@endsection

@section('js')
	<script>
		vue = {
			data: {
				group: '',
				ranks: {!! $ranks !!},
				search: ''
			},

			// computed: {
			// 	filteredRanks () {
			// 		let self = this
			// 		let filteredRanks = this.ranks.filter(function (rank) {
			// 			return rank.group_id == self.group
			// 		})

			// 		return filteredRanks.filter(function (rank) {
			// 			let searchRegex = new RegExp(self.search, 'i')

			// 			return searchRegex.test(rank.info.name) || searchRegex.test(rank.info.short_name)
			// 		})
			// 	}
			// },

			methods: {
				filteredRanks () {
					let self = this
					let filteredRanks = this.ranks.filter(function (rank) {
						return rank.group_id == self.group
					})

					return filteredRanks.filter(function (rank) {
						let searchRegex = new RegExp(self.search, 'i')

						return searchRegex.test(rank.info.name) || searchRegex.test(rank.info.short_name)
					})
				}
			},

			mounted () {
				Sortable.create(document.getElementById('sortable'), {
					handle: '.sortable-handle',
					onEnd (event) {
						let order = new Array()

						$(event.from).children().each(function () {
							let id = $(this).data('id')

							if (id) {
								order.push(id)
							}
						})

						axios.patch('/admin/ranks/items/reorder', {
							items: order
						})
					}
				})
			}
		}
	</script>
@endsection