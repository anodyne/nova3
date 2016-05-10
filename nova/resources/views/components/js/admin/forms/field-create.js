vue = {
	data: {
		fieldContainerClassSelect: "col-md-4",
		labelContainerClassSelect: "col-md-2",
		fieldContainerClass: "col-md-4",
		labelContainerClass: "col-md-2",
		label: "",
		type: "",
		help: "",
		status: "",
		tabId: false,
		sectionId: false,
		options: [
			{ text: "", value: "" }
		],
		attributes: [
			{ name: "class", value: "form-control input-lg" },
			{ name: "placeholder", value: "" }
		],
		rules: [
			{ type: "", value: "", hasValue: false }
		],
		restrictions: [
			{ type: "view", value: "" },
			{ type: "create", value: "" },
			{ type: "edit", value: "" }
		],
		hasValues: false,
		fieldType: {},
		fieldTypes: Nova.data.fieldTypesArr
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

		buildValidationRules: function() {
			var arrList = []

			for (var i = 0; i < this.rules.length; ++i) {
				var type = this.rules[i].type
				var value = this.rules[i].value

				var finalRule = type

				if (value != "") {
					finalRule += ":" + value.replace(/ /g,'')
				}

				arrList[i] = finalRule
			}

			this.validationRules = arrList.join('|')
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

		updateRuleValue: function (row) {
			//
		},

		updateValueName: function (row) {
			for (var i = 0; i < this.options.length; ++i) {
				if (this.options[i] === row) {
					this.options[i].value = this.options[i].text
					break
				}
			}
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
		},

		"type": function (value, oldValue) {
			var field = this.fieldTypes[value]

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