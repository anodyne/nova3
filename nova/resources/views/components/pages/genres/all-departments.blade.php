<h1>{{ _m('genre-depts', [2]) }}</h1>

@if ($departments->count() > 0)
	<div class="data-table bordered striped">
		<div class="row header">
			<div class="col">
				<mobile>
					<a href="#"
					   class="btn btn-secondary btn-action"
					   v-show="!mobileSearch"
					   @click.prevent="mobileSearch = true">{!! icon('search') !!}</a>

					<div class="input-group" v-show="mobileSearch">
						<input type="text" class="form-control" placeholder="{{ _m('genre-depts-find') }}" v-model="search">
						<span class="input-group-btn">
							<a class="btn btn-secondary" href="#" @click.prevent="resetSearch">{!! icon('close') !!}</a>
						</span>
					</div>
				</mobile>
				<desktop>
					<div class="input-group">
						<input type="text" class="form-control" placeholder="{{ _m('genre-depts-find') }}" v-model="search">
						<span class="input-group-btn">
							<a class="btn btn-secondary" href="#" @click.prevent="resetSearch">{!! icon('close') !!}</a>
						</span>
					</div>
				</desktop>
			</div>
			<div class="col d-none d-lg-block"></div>
			<div class="col col-auto" v-show="!mobileSearch">
				<div class="btn-toolbar">
					@can('create', $deptClass)
						<a href="{{ route('departments.create') }}" class="btn btn-success">{!! icon('add') !!}</a>
					@endcan

					@can('update', $deptClass)
						<div class="dropdown ml-2">
							<button type="button"
  									class="btn btn-secondary btn-action"
  									data-toggle="dropdown"
  									aria-haspopup="true"
  									aria-expanded="false">
								{!! icon('more') !!}
							</button>

							<div class="dropdown-menu dropdown-menu-right">
								<a href="{{ route('departments.reorder') }}" class="dropdown-item">
									{!! icon('reorder') !!} {{ _m('genre-depts-reorder') }}
								</a>
							</div>
						</div>
					@endcan
				</div>
			</div>
		</div>

		<div class="row" v-for="dept in filteredDepartments">
			<div class="col">
				<div class="row align-items-center">
					<div class="col">
						@{{ dept.name }}
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
								@can('update', $deptClass)
									<a :href="editLink(dept.id)" class="dropdown-item">
										{!! icon('edit') !!} {{ _m('edit') }}
									</a>
								@endcan

								@can('delete', $deptClass)
									<a href="#" class="dropdown-item text-danger" @click.prevent="deleteDepartment(dept.id)">
										{!! icon('delete') !!} {{ _m('delete') }}
									</a>
								@endcan
							</div>
						</div>
					</div>
				</div>

				<div class="row align-items-center"
					 v-if="dept.sub_departments.length > 0"
					 v-for="subDept in dept.sub_departments">
					<div class="col">
						<span class="ml-4">
							@{{ subDept.name }}
						</span>
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
								@can('update', $deptClass)
									<a :href="editLink(subDept.id)" class="dropdown-item">
										{!! icon('edit') !!} {{ _m('edit') }}
									</a>
								@endcan

								@can('delete', $deptClass)
									<a href="#" class="dropdown-item text-danger" @click.prevent="deleteDepartment(subDept.id)">{!! icon('delete') !!} {{ _m('delete') }}</a>
								@endcan
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@else
	<div class="alert alert-warning">
		{{ _m('genre-depts-error-not-found') }} <a href="{{ route('departments.create') }}" class="alert-link">{{ _m('genre-depts-error-add') }}</a>
	</div>
@endif