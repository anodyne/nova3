<script>
	vue = {
		data: {
			loading: true,
			loadingWithError: false,
			pages: [],
			search: "",
			verbs: []
		},

		methods: {
			removePage: function (pageId) {
				$('#removePage').modal({
					remote: "{{ url('admin/pages') }}/" + pageId + "/remove"
				}).modal('show')
			},

			resetFilters: function () {
				this.search = ""
				this.verbs = []
			}
		},

		ready: function () {
			var url = "{{ version('v1')->route('api.pages.index') }}"
			var options = {
				headers: {
					"Accept": "{{ config('nova.api.acceptHeader') }}"
				}
			}

			this.$http.get(url, [], options).then(response => {
				this.pages = response.data.data
			}, response => {
				this.loadingWithError = true
			})
		},

		watch: {
			"pages": function (value, oldValue) {
				if (value.length > 0) {
					this.loading = false
				}
			}
		}
	}
</script>