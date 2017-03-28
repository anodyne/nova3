Vue.filter('filterByCheckboxes', function (value, choices, filterKey) {
	var choicesArr = $.map(choices, function (val, key) {
		return [val]
	})
	
	return value.filter(function (item) {
		if (choicesArr.length > 0) {
			return $.inArray(item[filterKey], choicesArr) > -1
		}
		
		return true
	})
})