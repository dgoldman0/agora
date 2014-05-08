var agoraApp = angular.module('agoraApp', ['ngRoute']);

agoraApp.config(function($routeProvider) {
	$routeProvider.when('/shops', {
		templateUrl: 'partials/shop/list.html',
		controller: 'ShopListCtrl'
	}).when('/shop/:sid', {
		templateUrl: 'partials/shop/detailed.html',
		controller: 'ShopDetailCtrl'
	}).when('/shop/:sid/items/', {
		templateUrl: 'partials/item/list.html',
		controller: 'ItemListCtrl'
	}).when('/shop/:sid/item/:iid', {
		templateUrl: 'partials/item/detailed.html',
		controller: 'ItemDetailCtrl'
	}).otherwise({
		redirectTo: '/shops'
	});
});

agoraApp.controller('MainCtrl', function($scope, $http) {
	
});

agoraApp.controller('MenuCtrl', function($scope, $http, $routeParams) {
	$http.get("/shop.php?format=json", {params: {sid: 0} })
	.success(function (results) {
		$scope.$parent.shop = results.data;
	});		    	
});

agoraApp.controller('ShopListCtrl', function($scope, $http){
	$http.get("/shop.php?format=json").success(function (results) {
		$scope.shops = results.data;
	});		    	
});

agoraApp.controller('ShopDetailCtrl', function($scope, $http, $routeParams){
	$http.get("/item.php?format=json", {params: {sid: $routeParams.sid} })
	.success(function (results) {
		$scope.items = results.data;
	});
	$http.get("/shop.php?format=json", {params: {sid: $routeParams.sid} })
	.success(function (results) {
		$scope.$parent.shop = results.data;
	});		    	
});

agoraApp.controller('ItemListCtrl', function($scope, $http, $routeParams){
	$http.get("/item.php?format=json", {params: {sid: $routeParams.sid} })
	.success(function (results) {
		$scope.items = results.data;
	});
	$http.get("/shop.php?format=json", {params: {sid: $routeParams.sid} })
	.success(function (results) {
		$scope.$parent.shop = results.data;
	});		    	
});

agoraApp.controller('ItemDetailCtrl', function($scope, $http, $routeParams){
	$http.get("/item.php?format=json", {params: {iid: $routeParams.iid, sid: $routeParams.sid} })
	.success(function (results) {
		$scope.item = results.data;
	});
	$http.get("/shop.php?format=json", {params: {sid: $routeParams.sid} })
	.success(function (results) {
		$scope.$parent.shop = results.data;
	});		    	
});