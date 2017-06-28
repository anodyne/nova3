<template>
	<transition name="fade">
		<div :class="classes" role="alert" v-show="show">
			<h4 class="alert-heading" v-if="title != ''">{{ title }}</h4>
			<p v-if="title != ''">{{ body }}</p>
			<p v-if="title == ''">{{ title }}</p>
		</div>
	</transition>
</template>

<script>
	export default {
		props: ['message'],

		data () {
			return {
				body: '',
				level: 'success',
				show: false,
				startTransition: false,
				title: ''
			}
		},

		computed: {
			classes () {
				return ['alert', 'alert-flash', 'alert-' + this.level];
			}
		},

		methods: {
			flash (data) {
				this.body = data.message;
				this.level = data.level;
				this.title = data.title;
				this.show = true;

				this.hide();
			},

			hide () {
				var self = this;

				setTimeout(() => {
					self.startTransition = true;
				}, 4000);
			}
		},

		watch: {
			startTransition (newValue, oldValue) {
				if (newValue) {
					var self = this;

					$('.alert-flash').fadeOut(() => {
						self.show = false;
					});
				}
			}
		},

		created () {
			if (this.message) {
				console.log(this.message);
				this.flash(this.message, '', this.level);
			}

			window.events.$on('flash', (message, level) => this.flash(message, level));
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