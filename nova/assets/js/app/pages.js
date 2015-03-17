var app = angular.module('app', ['ngSanitize']).config(function($interpolateProvider)
{
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

app.controller('PagesLoadingController', function($scope)
{
	$scope.$on('load', function()
	{
		$scope.loading = true;
	});

	$scope.$on('unload', function()
	{
		$scope.loading = false;
	});
});

app.controller('PagesController', function($scope, $http, $window, filterFilter)
{
	$scope.$emit('load');

	// Initialize the list of pages
	$scope.pages = {};
	$scope.useVerbs = {};

	// Get the pages
	$http({
		url: $window.baseUrl + "/admin/pages/get",
		method: "GET"
	}).success(function (data)
	{
		$scope.pages = data;

		$scope.$watch(function()
		{
			return {
				pages: $scope.pages,
				useVerbs: $scope.useVerbs
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

			$scope.verbsGroup = uniqueItems($scope.pages, 'verb');

			$scope.$emit('unload');

			var filterAfterVerbs = [];
			selected = false;
			for (var j in $scope.pages)
			{
				var p = $scope.pages[j];
				for (var i in $scope.useVerbs)
				{
					if ($scope.useVerbs[i])
					{
						selected = true;

						if (i == p.verb)
						{
							filterAfterVerbs.push(p);
							break;
						}
					}
				}
			}
			if ( ! selected)
				filterAfterVerbs = $scope.pages;

			$scope.filteredPages = filterAfterVerbs;
		}, true);
	});
});
