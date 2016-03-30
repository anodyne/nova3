<script>
	vue = {
		data: {
			loading: true,
			loadingWithError: false,
			baseUrl: "{{ Request::root() }}",
			key: "",
			value: "",
			contents: []
		},

		methods: {
			removeContent: function (contentId) {
				$('#removeContent').modal({
					remote: "{{ url('admin/content') }}/" + contentId + "/remove"
				}).modal('show')
			},

			resetFilters: function () {
				this.key = ""
				this.value = ""
			}
		},

		ready: function () {
			this.$http.get(this.baseUrl + '/api/page-contents').then(function (response) {
				this.contents = response.data.data
			}, function (response) {
				this.loadingWithError = true
			})
		},

		watch: {
			"contents": function (value, oldValue) {
				if (value.length > 0)
					this.loading = false
			}
		}
	}
</script>