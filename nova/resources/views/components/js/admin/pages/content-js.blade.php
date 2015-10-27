<script>
	var vm = new Vue({
		el: "#app",
		data: {
			loading: true,
			loadingWithError: false,
			baseUrl: "{{ Request::root() }}",
			key: "",
			value: "",
			contents: []
		},
		methods: {
			resetFilters: function()
			{
				this.$set("key", "")
				this.$set("value", "")
			}
		},
		ready: function()
		{
			this.$http.get(this.baseUrl + '/api/page-contents', function (data, status, request)
			{
				this.$set('contents', data.data)
			}).error(function (data, status, request)
			{
				this.$set('loadingWithError', true)
			})
		}
	});

	vm.$watch('contents', function (newValue, oldValue)
	{
		if (newValue.length > 0)
			this.$set('loading', false)
	})

	$(document).on('click', '.js-contentAction', function(e)
	{
		e.preventDefault();

		var contentId = $(this).data('id');
		var action = $(this).data('action');

		if (action == 'remove')
		{
			$('#removeContent').modal({
				remote: "{{ url('admin/content') }}/" + contentId + "/remove"
			}).modal('show');
		}
	});
</script>