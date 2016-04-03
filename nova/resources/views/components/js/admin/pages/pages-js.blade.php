<script>
	vue = {
		data: {
			loading: true,
			loadingWithError: false,
			baseUrl: "{{ Request::root() }}",
			search: "",
			verbs: [],
			pages: []
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
			var url = this.baseUrl + '/api/pages'

			this.$http.get(url).then(function (response) {
				this.pages = response.data.data
			}, function (response) {
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