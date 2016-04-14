<script>
	vue = {
		data: {
			loading: true,
			loadingWithError: false,
			permissions: [],
			search: ""
		},

		methods: {
			removePermission: function (permissionId) {
				$('#removePermission').modal({
					remote: "{{ url('admin/access/permissions') }}/" + permissionId + "/remove"
				}).modal('show')
			},

			resetFilters: function () {
				this.search = ""
			}
		},

		ready: function () {
			var url = "{{ version('v1')->route('api.access.permissions.index') }}"
			var options = {
				headers: {
					"Accept": "{{ config('nova.api.acceptHeader') }}"
				}
			}
			
			this.$http.get(url, [], options).then(response => {
				this.permissions = response.data.data
			}, response => {
				this.loadingWithError = true
			})
		},

		watch: {
			"permissions": function (value, oldValue) {
				if (value.length > 0) {
					this.loading = false
				}
			}
		}
	}
</script>