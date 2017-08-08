<template>
	<div class="card">
		<img class="card-img-top" :src="getFile(file)">
		<div class="card-footer">
			<a href="#" class="card-link" @click.prevent="makePrimary">{!! icon('star') !!}</a>
			<a href="#" class="card-link text-danger" @click.prevent="removeFile">{!! icon('delete') !!}</a>
		</div>
	</div>
</template>

<script>
	export default {
		props: {
			file: { type: Object, required: true }
		},

		methods: {
			destroy () {},
			
			store () {}
		}
	}
</script>