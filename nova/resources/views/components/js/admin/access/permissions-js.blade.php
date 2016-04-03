<script>
	vue = {
		data: {
			loading: true,
			loadingWithError: false,
			baseUrl: "{{ Request::root() }}",
			search: "",
			permissions: []
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
			var url = this.baseUrl + '/api/access/permissions'
			
			this.$http.get(url).then(function (response) {
				this.permissions = response.data.data
			}, function (response) {
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