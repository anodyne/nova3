<script>
	var vm = new Vue({
		el: "#app",
		data: {
			loading: true,
			loadingWithError: false,
			baseUrl: "{{ Request::root() }}",
			display_name: "",
			name: "",
			permissions: []
		},

		methods: {
			removePermission: function(permissionId)
			{
				$('#removePermission').modal({
					remote: "{{ url('admin/access/permissions') }}/" + permissionId + "/remove"
				}).modal('show');
			},

			resetFilters: function()
			{
				this.display_name = "";
				this.name = "";
			}
		},

		ready: function()
		{
			this.$http.get(this.baseUrl + '/api/access/permissions', function (data, status, request)
			{
				this.permissions = data.data;
			}).error(function (data, status, request)
			{
				this.loadingWithError = true;
			});
		}
	});

	vm.$watch('permissions', function (newValue, oldValue)
	{
		if (newValue.length > 0)
			this.loading = false;
	});
</script>