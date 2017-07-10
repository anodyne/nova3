@extends('layouts.app')

@section('title', _m('genre-depts'))

@section('content')
	<h1>{{ _m('genre-depts') }}</h1>

	<mobile>
		<div class="row">
			@can('create', $deptClass)
				<div class="col">
					<p><a href="{{ route('departments.create') }}" class="btn btn-success btn-block">{{ _m('genre-dept-add') }}</a></p>
				</div>
			@endcan
		</div>
	</mobile>

	<desktop>
		<div class="btn-toolbar">
			@can('create', $deptClass)
				<div class="btn-group">
					<a href="{{ route('departments.create') }}" class="btn btn-success">{{ _m('genre-dept-add') }}</a>
				</div>
			@endcan
		</div>
	</desktop>

	@if ($departments->count() > 0)
		<div class="row">
			<div class="col-md-4">
				<div class="form-group">
					<div class="input-group">
						<input type="text" class="form-control" placeholder="{{ _m('genre-dept-find') }}" v-model="searchDepartments">
						<span class="input-group-btn">
							<a class="btn btn-secondary" href="#" @click.prevent="searchDepartments = ''">{!! icon('close') !!}</a>
						</span>
					</div>
				</div>
			</div>
		</div>

		<div class="data-table bordered striped">
			<div class="data-table-row data-table-header">
				<div class="data-table-row-item">{{ _m('name') }}</div>
				<div class="data-table-row-item"></div>
			</div>
			<div class="data-table-row" v-for="dept in filteredDepartments">
				<div class="data-table-row-item" data-header="{{ _m('name') }}">
					@{{ dept.name }}
				</div>
				<div class="data-table-row-item">
					<div class="dropdown pull-right">
						<button class="btn btn-secondary"
								type="button"
								id="dropdownMenuButton"
								data-toggle="dropdown"
								aria-haspopup="true"
								aria-expanded="false">
							{!! icon('more') !!}
						</button>
						<div class="dropdown-menu dropdown-menu-right"
							 aria-labelledby="dropdownMenuButton">
							@can('update', $deptClass)
								<a :href="'/admin/departments/' + dept.id + '/edit'" class="dropdown-item">{!! icon('edit') !!} {{ _m('edit') }}</a>
							@endcan

							@can('delete', $deptClass)
								<a href="#" class="dropdown-item text-danger" :data-department="dept.id" @click.prevent="deleteDepartment">{!! icon('delete') !!} {{ _m('delete') }}</a>
							@endcan
						</div>
					</div>
				</div>

				<div class="col" v-if="dept.children.length > 0">
					<p class="ml-3">Has sub-departments</p>
				</div>
			</div>
		</div>

		<table class="table">
			<thead class="thead-default">
				<tr>
					<th colspan="2">{{ _m('name') }}</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="dept in filteredDepartments">
					<td>
						<table class="table">
							<tbody>
								<tr>
									<td>@{{ dept.name }}</td>
									<td>
										<div class="dropdown pull-right">
											<button class="btn btn-secondary"
													type="button"
													id="dropdownMenuButton"
													data-toggle="dropdown"
													aria-haspopup="true"
													aria-expanded="false">
												{!! icon('more') !!}
											</button>
											<div class="dropdown-menu dropdown-menu-right"
												 aria-labelledby="dropdownMenuButton">
												@can('update', $deptClass)
													<a :href="'/admin/departments/' + dept.id + '/edit'" class="dropdown-item">{!! icon('edit') !!} {{ _m('edit') }}</a>
												@endcan

												@can('delete', $deptClass)
													<a href="#" class="dropdown-item text-danger" :data-department="dept.id" @click.prevent="deleteDepartment">{!! icon('delete') !!} {{ _m('delete') }}</a>
												@endcan
											</div>
										</div>
									</td>
								</tr>
								<tr v-for="subDept in dept.children" v-if="dept.children.length > 0">
									<td><span class="ml-3">@{{ subDept.name }}</span></td>
									<td>
										<div class="dropdown pull-right">
											<button class="btn btn-secondary"
													type="button"
													id="dropdownMenuButton"
													data-toggle="dropdown"
													aria-haspopup="true"
													aria-expanded="false">
												{!! icon('more') !!}
											</button>
											<div class="dropdown-menu dropdown-menu-right"
												 aria-labelledby="dropdownMenuButton">
												@can('update', $deptClass)
													<a :href="'/admin/departments/' + subDept.id + '/edit'" class="dropdown-item">{!! icon('edit') !!} {{ _m('edit') }}</a>
												@endcan

												@can('delete', $deptClass)
													<a href="#" class="dropdown-item text-danger" :data-department="subDept.id" @click.prevent="deleteDepartment">{!! icon('delete') !!} {{ _m('delete') }}</a>
												@endcan
											</div>
										</div>
									</td>
								</tr>
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
		</table>
	@else
		<div class="alert alert-warning">
			{{ _m('genre-dept-error-not-found') }} <a href="{{ route('departments.create') }}" class="alert-link">{{ _m('genre-dept-error-add') }}</a>
		</div>
	@endif
@endsection

@section('js')
	<script>
		vue = {
			data: {
				departments: {!! $departments !!},
				searchDepartments: ''
			},

			computed: {
				filteredDepartments () {
					let self = this

					return self.departments.filter(function (dept) {
						let searchRegex = new RegExp(self.searchDepartments, 'i')

						return searchRegex.test(dept.name)
					})
				}
			},

			methods: {
				deleteDepartment (event) {
					$.confirm({
						title: "{{ _m('genre-dept-delete-title') }}",
						content: "{{ _m('genre-dept-delete-message') }}",
						theme: "dark",
						buttons: {
							confirm: {
								text: "{{ _m('delete') }}",
								btnClass: "btn-danger",
								action () {
									let department = event.target.getAttribute('data-department')

									axios.delete('/admin/departments/' + department)

									window.setTimeout(() => {
										window.location.replace('/admin/departments')
									}, 2000)
								}
							},
							cancel: {
								text: "{{ _m('cancel') }}"
							}
						}
					})
				}
			}
		}
	</script>
@endsection