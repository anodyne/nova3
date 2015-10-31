<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/1.0.3/vue.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/0.1.16/vue-resource.min.js"></script>
{!! HTML::script('nova/resources/js/vue-components.js') !!}
{!! HTML::script('nova/resources/js/vue-filters.js') !!}
<script>
	Vue.config.delimiters = ['{%', '%}']
	Vue.config.unsafeDelimiters = ['{%!', '!%}']

	var vm = new Vue({
		el: "#app",
		mixins: [vue]
	});
</script>
