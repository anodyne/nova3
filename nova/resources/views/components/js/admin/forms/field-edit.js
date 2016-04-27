vue = {
	data: {
		fieldContainerClassSelect: "col-md-4",
		labelContainerClassSelect: "col-md-2",
		fieldContainerClass: "col-md-4",
		labelContainerClass: "col-md-2",
		label: "",
		type: "",
		help: "",
		hasValues: false,
		options: [
			{ text: "", value: "" }
		],
		attributes: [],
		rules: [
			{ type: "", value: "", hasValue: false }
		],
		restrictions: [
			{ type: "view", value: "" },
			{ type: "create", value: "" },
			{ type: "edit", value: "" }
		],
		fieldType: {},
		fieldTypes: Nova.data.fieldTypes
	},

	computed: {
		attrClass: function () {
			var obj = find("attributes", "class")

			if (obj) {
				return obj.value
			}

			return
		},

		attrPlaceholder: function () {
			var obj = find("attributes", "placeholder")

			if (obj) {
				return obj.value
			}

			return
		},

		attrRows: function () {
			var obj = find("attributes", "rows")

			if (obj) {
				return obj.value
			}

			return
		},

		attrMin: function () {
			var obj = find("attributes", "min")

			if (obj) {
				return obj.value
			}

			return
		},

		attrMax: function () {
			var obj = find("attributes", "max")

			if (obj) {
				return obj.value
			}

			return
		},

		attrValue: function () {
			var obj = find("attributes", "value")

			if (obj) {
				return obj.value
			}

			return
		},

		attrStep: function () {
			var obj = find("attributes", "step")

			if (obj) {
				return obj.value
			}

			return
		},

		hasType: function () {
			return this.type != ""
		}
	},

	methods: {
		addAttribute: function () {
			this.attributes.push({ name: "", value: "" })
		},

		addOption: function () {
			this.options.push({ text: "", value: "" })
		},

		addRule: function () {
			this.rules.push({ type: "", value: "", hasValue: false })
		},

		clearRestriction: function (row) {
			for (var i = 0; i < this.restrictions.length; ++i) {
				if (this.restrictions[i] === row) {
					this.restrictions[i].value = ""
					break
				}
			}
		},

		removeAttribute: function (row) {
			this.attributes.$remove(row)
		},

		removeOption: function (row) {
			this.options.$remove(row)
		},

		removeRule: function (row) {
			this.rules.$remove(row)
		},

		updateRuleType: function (row) {
			switch (row.type) {
				case "between":
				case "exists":
				case "in":
				case "max":
				case "min":
				case "not_in":
					row.hasValue = true
					row.value = ""
				break

				default:
					row.hasValue = false
					row.value = ""
				break
			}
		},

		updateType: function () {
			var field = this.fieldTypes[this.type]

			this.fieldType = field

			// Clear out the field values
			this.options = [
				{ text: "", value: "" }
			]

			// Clear out the validation rules
			this.rules = [
				{ type: "", value: "", hasValue: false }
			]

			// Reset the attributes
			this.attributes = field.attributes

			// Reset the restrictions
			this.restrictions = [
				{ type: "view", value: "" },
				{ type: "create", value: "" },
				{ type: "edit", value: "" }
			]

			// Reset some other values
			this.fieldContainerClassSelect = field.fieldContainerSize
			this.labelContainerClassSelect = field.labelContainerSize
			this.hasValues = field.hasValues
		}
	},

	ready: function () {
		var attributes = Nova.data.attributes
		var options = Nova.data.values
		var restrictions = Nova.data.restrictions
		var rules = Nova.data.validationRules

		if (attributes) {
			this.attributes = []

			for (var a = 0; a < attributes.length; ++a) {
				this.attributes.push({ name: attributes[a].name, value: attributes[a].value  })
			}
		}

		if (options) {
			this.options = []

			for (var o = 0; o < options.length; ++o) {
				this.options.push({ text: options[o].text, value: options[o].value })
			}
		}

		if (restrictions) {
			this.restrictions = []

			for (var r = 0; r < restrictions.length; ++r) {
				this.restrictions.push({ type: restrictions[r].type, value: restrictions[r].value })
			}
		}

		if (rules) {
			this.rules = []

			for (var v = 0; v < rules.length; ++v) {
				var hasValue = (rules[v].value)

				this.rules.push({ type: rules[v].type, value: rules[v].value, hasValue: hasValue })
			}
		}

		var containerSizes = ['col-md-2', 'col-md-4', 'col-md-6', 'col-md-8', 'col-md-10', 'col-md-12']

		if ($.inArray(this.fieldContainerClass, containerSizes) < 0) {
			this.fieldContainerClassSelect = "Custom"
		}

		if ($.inArray(this.labelContainerClass, containerSizes) < 0) {
			this.labelContainerClassSelect = "Custom"
		}

		this.fieldType = this.fieldTypes[this.type]

		if (this.type == "radio" || this.type == "select") {
			this.hasValues = true
		}
	},

	watch: {
		"fieldContainerClassSelect": function (value, oldValue) {
			if (value != "Custom") {
				this.fieldContainerClass = value
			}
		},

		"labelContainerClassSelect": function (value, oldValue) {
			if (value != "Custom") {
				this.labelContainerClass = value
			}
		}
	}
}

function find(item, name) {
	if ( ! vue.data[item]) {
		return
	}

	var items = vue.data[item]

	for (var i = 0; i < items.length; ++i) {
		if (items[i].name === name) {
			return items[i]
		}
	}
}

Sortable.create(byId("sortable"), {
	handle: ".sortable-handle"
})