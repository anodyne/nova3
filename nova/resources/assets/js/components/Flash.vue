<template>
	<transition name="fade">
		<div :class="classes" role="alert" v-show="show">
			<h4 class="alert-heading" v-if="heading != ''">{{ heading }}</h4>
			<p v-if="heading != ''">{{ body }}</p>
			<p v-if="heading == ''">{{ heading }}</p>
		</div>
	</transition>
</template>

<script>
	export default {
		props: ['message', 'title', 'level'],

		data () {
			return {
				body: '',
				show: false,
				type: '',
				heading: '',
				startTransition: false
			}
		},

		computed: {
			classes () {
				return ['alert', 'alert-flash', 'alert-' + this.type];
			}
		},

		methods: {
			flash (message, title, level) {
				this.body = message;
				this.type = level;
				this.heading = title;
				this.show = true;

				this.hide();
			},

			hide () {
				console.log('inside hide()');
				var self = this;

				setTimeout(() => {
					console.log('inside setTimeout');
					self.startTransition = true;
				}, 4000);
			}
		},

		watch: {
			startTransition (newValue, oldValue) {
				console.log('inside startTransition()');
				console.log(newValue, oldValue);
				if (newValue) {
					console.log('has newValue');
					var self = this;

					$('.alert-flash').fadeOut(() => {
						self.show = false;
						self.startTransition = false;
					});
				}
			}
		},

		mounted () {
			var self = this;

			if (this.message) {
				this.flash(this.message, this.title, this.level);
			}

			window.events.$on('flash', (message, title, level) => self.flash(message, title, level));
		}
	};
</script>

<style lang="scss">
	.fade-enter-active, .fade-leave-active {
		transition: opacity .5s
	}

	.fade-enter, .fade-leave-to {
		opacity: 0
	}
</style>