var app = angular.module('app', []).config(function($interpolateProvider)
{
	// Change the start and end symbols so we don't clash with Blade
	$interpolateProvider.startSymbol('{%').endSymbol('%}');
});

var uniqueItems = function (data, key)
{
	var result = [];

	for (var i = 0; i < data.length; i++)
	{
		var value = data[i][key];

		if (result.indexOf(value) == -1)
			result.push(value);
	}

	return result;
}

app.controller('PageContentsLoadingController', function ($scope)
{
	// Listen for the load event
	$scope.$on('load', function()
	{
		$scope.loading = true;
	});

	// Listen for the unload event
	$scope.$on('unload', function()
	{
		$scope.loading = false;
	});
});

app.controller('PageContentsController', function ($scope, $http, $window, filterFilter)
{
	// We're loading the page
	$scope.$emit('load');

	// Initialize the list of pages
	$scope.contents = {};
	$scope.useTypes = {};

	// Get the pages
	$http({
		url: $window.baseUrl + "/api/page-contents",
		method: "GET"
	}).success(function (data)
	{
		$scope.contents = data.data;

		$scope.$watch(function()
		{
			return {
				contents: $scope.contents,
				useTypes: $scope.useTypes
			}
		}, function (value)
		{
			var selected;

			$scope.count = function (prop, value)
			{
				return function (el)
				{
					return el[prop] == value;
				};
			};

			// Grab all of the verbs referenced in the pages collection
			$scope.typesGroup = uniqueItems($scope.contents, 'type');

			// We're done loading the page now
			$scope.$emit('unload');

			var filterAfterTypes = [];
			
			selected = false;
			
			for (var j in $scope.contents)
			{
				var p = $scope.contents[j];

				for (var i in $scope.useTypes)
				{
					if ($scope.useTypes[i])
					{
						selected = true;

						if (i == p.type)
						{
							filterAfterTypes.push(p);
							break;
						}
					}
				}
			}
			
			if ( ! selected)
				filterAfterTypes = $scope.contents;

			$scope.filteredContents = filterAfterTypes;
		}, true);
	});
});
