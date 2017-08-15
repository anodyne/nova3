<template>
	<div class="form-group">
		<div v-show="!uploadedFile">
			<div v-if="allowMultiple || (!allowMultiple && files.length == 0)">
				<label for="file-upload" class="btn btn-secondary" v-html="showIcon('add')"></label>
				<input type="file" id="file-upload" name="file" class="hidden" @change="processFile">
			</div>

			<div class="row mt-3" id="sortable">
				<div class="col-sm-6 col-lg-3 draggable-item" :data-id="file.id" v-for="file in files">
					<div class="card">
						<img class="card-img-top" :src="getFile(file)">
						<div class="card-footer d-flex justify-content-between">
							<div>
								<span v-if="allowMultiple">
									<a href="#"
									   class="card-link mr-2"
									   v-if="!isPrimary(file)"
									   @click.prevent="makePrimary(file.id)"
									   v-html="showIcon('star')"></a>
									<span class="card-link text-warning mr-2"
										  v-if="isPrimary(file)"
										  v-html="showIcon('star')"></span>
								</span>
								<a href="#"
								   class="card-link text-danger"
								   @click.prevent="deleteFile(file.id)"
								   v-html="showIcon('delete')"></a>
							</div>
							<div v-if="allowMultiple">
								<div class="card-link text-subtle sortable-handle" v-html="showIcon('bars')"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div v-show="uploadedFile">
			<div id="crop"></div>

			<div class="d-flex justify-content-around">
				<span>
					<button class="btn btn-success"
							@click.prevent="saveFile"
							v-html="showIcon('upload')"></button>
					<button class="btn btn-secondary ml-2"
							@click.prevent="reset"
							v-html="showIcon('close')"></button>
				</span>
			</div>
		</div>
	</div>
</template>

<script>
	import Croppie from 'croppie'
	import pluralize from 'pluralize'

	export default {
		props: {
			allowMultiple: { type: Boolean, default: true },
			item: { type: Object, required: true },
			type: { type: String, required: true }
		},

		data () {
			return {
				crop: {},
				files: this.item.media,
				uploadedFile: '',
			}
		},

		methods: {
			createCropper () {
				this.crop = new Croppie(document.getElementById('crop'), {
					boundary: {
						width: Math.min(500, window.innerWidth - 10),
						height: Math.min(500, window.innerHeight - 10)
					},
					customClass: 'crop-container',
					viewport: {
						width: Math.min(500, window.innerWidth - 10),
						height: Math.min(500, window.innerHeight - 10)
					}
				})
			},

			createFile (file) {
				let reader = new FileReader()
				let self = this

				reader.onload = (event) => {
					self.uploadedFile = event.target.result

					self.crop.bind({
						url: self.uploadedFile
					})
				}

				reader.readAsDataURL(file)
			},

			deleteFile (id) {
				let self = this

				$.confirm({
					title: "Delete Media",
					content: "Are you sure you want to delete this media?",
					columnClass: "medium",
					theme: "dark",
					buttons: {
						confirm: {
							text: "Delete",
							btnClass: "btn-danger",
							action () {
								axios.delete(route('media.destroy', {media:id}))
									 .then(function (response) {
									 	let index = _.findIndex(self.files, function (f) {
											return f.id == id
										})

										self.files.splice(index, 1)

										flash('The media has been deleted', '')
									 })
							}
						},
						cancel: {
							text: "Cancel"
						}
					}
				})
			},

			isPrimary (file) {
				return file.primary === 1
			},

			processFile (event) {
				let files = event.target.files || event.dataTransfer.files

				if (! files.length) {
					return
				}

				this.createFile(files[0])
			},

			getFile (file) {
				return [
					window.Nova.baseUrl,
					'storage',
					'app',
					'public',
					pluralize(this.type),
					file.filename
				].join('/')
			},

			makePrimary (id) {
				axios.patch(route('media.update', {media:id}))

				_.each(this.files, (file) => {
					if (file.id != id) {
						file.primary = 0
					} else {
						file.primary = 1
					}
				})

				flash('Primary image updated', '', 'success')
			},

			reset () {
				document.getElementById('file-upload').value = ''
				this.uploadedFile = ''
			},

			saveFile () {
				let self = this

				this.crop.result('canvas').then(function (canvas) {
					axios.post(route('media.store'), {
						image: canvas,
						location: pluralize(self.type),
						id: self.item.id,
						type: self.type
					}).then(function (response) {
						self.files.push(response.data)

						flash('Media saved', 'File saved', 'success')
					})
				})

				this.reset()
			},

			showIcon (icon) {
				return window.icon(icon)
			}
		},

		mounted () {
			this.createCropper()

			if (this.allowMultiple) {
				Sortable.create(document.getElementById('sortable'), {
					draggable: '.draggable-item',
					handle: '.sortable-handle',
					onEnd (event) {
						let order = new Array()

						$(event.from).children().each(function () {
							let id = $(this).data('id')

							if (id) {
								order.push(id)
							}
						})

						axios.patch(route('media.reorder'), {
							media: order
						})
					}
				})
			}
		}
	}
</script>