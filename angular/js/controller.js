var agoraApp = angular.module('agoraApp', ['ngRoute', 'ngSanitize']);

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
	$.fn.raty.defaults.path = '/images';
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
	$scope.min_score = 3.5;
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

agoraApp.controller('ItemSortCtrl', function ($scope, $http, $routeParams) {
	$http.get("/item_category.php?format=json", {params: {sid: $routeParams.sid} }).success(function (results) {
		$scope.categories = results.data;
	});
}).directive('categories', function() { // Quickly thrown together without knowing what I'm doing. Works, but probably not right
	return {
		restrict: 'A',
		link: function($scope, $element, $attrs)
		{
			$scope.$watch('categories', function() {
				// Build category structure
				var root = $scope.cat_tree;
				if (root == null)
				{
					root = $('<ul id="cat_root"><li>All Items</li></ul>');
					$($element).append(root);
					$scope.cat_tree = root;
				}
				var rootli = root.find('li').first();
				var categories = $scope.categories;
				if (categories != null)
				{
					var h = new Object();
					// Required ordering by last updated or something in order to prevent category being created before parent
					for (i = 0; i < categories.length; i++)
					{
						var cat = categories[i];
						var text = '<ul id="cat-'+cat.id+'"><li>'+cat.name+'</li></ul>';
						h[cat.id] = $(text);
						if (cat.parent == null)
						{
							rootli.append(h[cat.id]);
						} else
						{
							h[cat.parent].find('li').first().append(h[cat.id]);
						}
					}
					$($element).jstree({"types" : {
				    	"default" : {
				        	"icon" : "glyphicon glyphicon-tower"
				      	},
				      	"demo" : {
				        	"icon" : "glyphicon glyphicon-ok"
				      		}
				   		},
				    	"plugins" : [ "types" ]
					});
				}
			});
		}
	};
}).directive('scores', function($compile) {
	return {
		restrict: 'A',
      	link: function($scope, $element, $attrs)
		{
			var div = $('<div/>');
			var onClick = function(score, evt)
			{
				$scope.$parent.$parent.min_score = score;
			};
			div.raty({
				number: 5,
				half: true,
				score: 3.5,
				click: onClick
  			});
			$compile(div)($scope);
			$($element.append(div));
			$scope.$watch('min_score', function () {
				console.log($scope.min_score);
			});
		}
	};
});

agoraApp.controller('ItemReviewListCtrl', function ($scope, $http, $routeParams) {
	$http.get("/item_review.php?format=json", {params: {iid: $routeParams.iid} }).success(function (results) {
		$scope.reviews = results.data;
		
	});
});