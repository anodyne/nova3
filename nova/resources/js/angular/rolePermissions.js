var app = angular.module('app', ['ngSanitize', 'angular-toArrayFilter']).config(function($interpolateProvider)
{
	// Change the start and end symbols so we don't clash with Blade
	$interpolateProvider.startSymbol('{%').endSymbol('%}');
});

app.controller('PermissionsLoadingController', function ($scope)
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

app.controller('PermissionsController', function ($scope, $http, $window, filterFilter)
{
	// We're loading the page
	$scope.$emit('load');

	// Initialize the list of permissions
	$scope.permissions = {};

	// Get the permissions
	$http({
		url: $window.baseUrl + "/api/access/permissions",
		method: "GET"
	}).success(function (data)
	{
		$scope.permissions = data.data;

		$scope.$watch(function()
		{
			return {
				permissions: $scope.permissions
			}
		}, function (value)
		{
			// We're done loading the page now
			$scope.$emit('unload');
		}, true);
	});
});
