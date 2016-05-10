Vue.component('desktop-lg', {
	template: '<div class="visible-lg-block" v-cloak><slot></slot></div>'
})

Vue.component('desktop-sm', {
	template: '<div class="visible-md-block" v-cloak><slot></slot></div>'
})

Vue.component('desktop', {
	template: '<div class="visible-md-block visible-lg-block" v-cloak><slot></slot></div>'
})

Vue.component('mobile', {
	template: '<div class="visible-xs-block visible-sm-block" v-cloak><slot></slot></div>'
})

Vue.component('phone', {
	template: '<div class="visible-xs-block" v-cloak><slot></slot></div>'
})

Vue.component('tablet', {
	template: '<div class="visible-sm-block" v-cloak><slot></slot></div>'
})

Vue.component('tablet-desktop', {
	template: '<div class="visible-sm-block visible-md-block visible-lg-block" v-cloak><slot></slot></div>'
})

Vue.component('access-picker', {
	template: "#access-picker-template",

	props: {
		permissions: [],
		roles: []
	},

	data: function () {
		return {
			items: [],
			query: "",
			selectedItem: {}
		}
	},

	computed: {
		permissionString: function () {
			var output = new Array()
			var items = this.items.filter(function (item) {
				return item.type == 'permission'
			})

			for (var i = 0; i < items.length; i++) {
				output.push(items[i].key)
			}

			return output.join(',')
		},

		roleString: function () {
			var output = new Array()
			var items = this.items.filter(function (item) {
				return item.type == 'role'
			})

			for (var i = 0; i < items.length; i++) {
				output.push(items[i].key)
			}

			return output.join(',')
		}
	},

	methods: {
		removeSelectedItem: function (row) {
			this.items.$remove(row)
		}
	},

	ready: function () {
		var permissions = new Bloodhound({
			datumTokenizer: Bloodhound.tokenizers.obj.whitespace('key', 'name'),
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			local: this.permissions
		})

		var roles = new Bloodhound({
			datumTokenizer: Bloodhound.tokenizers.obj.whitespace('key', 'name'),
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			local: this.roles
		})

		$('[name="typeahead"]').typeahead({
			highlight: true
		}, {
			name: "nova-roles",
			source: roles,
			display: "name",
			templates: {
				header: '<h4>Roles</h4>'
			}
		}, {
			name: "nova-permissions",
			source: permissions,
			display: "name",
			templates: {
				header: '<h4>Permissions</h4>'
			}
		})

		var cvm = this

		$('[name="typeahead"]').bind('typeahead:select', function(ev, suggestion) {
			cvm.selectedItem = suggestion
			cvm.query = ""
			$(this).typeahead('val', '')
		})
	},

	watch: {
		"selectedItem": function (newValue, oldValue) {
			if (newValue != "" && newValue != oldValue) {
				var type = (newValue.protected !== undefined) ? 'permission' : 'role'

				this.items.push({ type: type, name: newValue.name, key: newValue.key })
			}
		}
	}
})