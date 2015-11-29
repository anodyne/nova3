<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.10/vue.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/0.1.17/vue-resource.js"></script>
{!! HTML::script('nova/resources/js/vue-components.js') !!}
{!! HTML::script('nova/resources/js/vue-filters.js') !!}
<script>
	var vm = new Vue(
	{
		el: '#app',
		mixins: [vue],
		http: {
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		}
	})
</script>