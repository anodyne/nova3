<template>
	<div class="rank-container">
		<div class="rank-overlay" :style="overlayStyle()"></div>
		<div class="rank-base" :style="baseStyle()"></div>
	</div>
</template>

<script>
	export default {
		props: {
			item: { type: Object },
			base: { type: String },
			overlay: { type: String }
		},

		methods: {
			baseStyle () {
				let image = (this.item) ? this.item.base : this.base;
				let imagePath;

				if (image) {
					imagePath = [
						Nova.system.baseUrl,
						'ranks',
						Nova.settings.rank,
						'base',
						image
					].join('/');
				} else {
					imagePath = [
						Nova.system.baseUrl,
						'ranks',
						Nova.settings.rank,
						'blank.png'
					].join('/');
				}

				return 'background-image:url(' + imagePath + ')';
			},

			overlayStyle () {
				let image = (this.item) ? this.item.overlay : this.overlay;
				let imagePath = [].join('/');

				if (image) {
					imagePath = [
						Nova.system.baseUrl,
						'ranks',
						Nova.settings.rank,
						'overlay',
						image
					].join('/');
				}

				return 'background-image:url(' + imagePath + ')';
			}
		}
	};
</script>
