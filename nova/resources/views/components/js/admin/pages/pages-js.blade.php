<script>
	var vm = new Vue({
		el: "#app",
		data: {
			loading: true,
			loadingWithError: false,
			baseUrl: "{{ Request::root() }}",
			name: "",
			key: "",
			uri: "",
			verbs: [],
			pages: []
		},

		methods: {
			removePage: function(pageId)
			{
				$('#removePage').modal({
					remote: "{{ url('admin/pages') }}/" + pageId + "/remove"
				}).modal('show');
			},

			resetFilters: function()
			{
				this.name = "";
				this.key = "";
				this.uri = "";
				this.verbs = [];
			}
		},

		ready: function()
		{
			this.$http.get(this.baseUrl + '/api/pages', function (data, status, request)
			{
				this.pages = data.data;
			}).error(function (data, status, request)
			{
				this.loadingWithError = true;
			});
		}
	});

	vm.$watch('pages', function (newValue, oldValue)
	{
		if (newValue.length > 0)
			this.loading = false;
	});
</script>