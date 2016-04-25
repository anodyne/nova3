<script>
	vue = {
		data: {
			loading: true,
			loadingWithError: false,
			users: [],
			search: "",
			statuses: ["active"]
		},

		methods: {
			removeUser: function (userId) {
				$('#removeUser').modal({
					remote: "{{ url('admin/users') }}/" + userId + "/remove"
				}).modal('show')
			},

			resetFilters: function () {
				this.search = ""
				this.statuses = ["active"]
			}
		},

		ready: function () {
			var url = "{{ version('v1')->route('api.users.index') }}"
			var options = {
				headers: {
					"Accept": "{{ config('nova.api.acceptHeader') }}"
				}
			}

			this.$http.get(url, [], options).then(response => {
				this.users = response.data.data
			}, response => {
				this.loadingWithError = true
			})
		},

		watch: {
			"users": function (value, oldValue) {
				if (value.length > 0) {
					this.loading = false
				}
			}
		}
	}
</script>