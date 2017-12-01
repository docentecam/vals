angular.module('spaApp')
.controller('PromotionsCtrl', function($scope, $http, $routeParams) {
	$scope.loading=true;
	$scope.service = false;
 	$scope.facebook = false;
 	$scope.twitter = false;
 	$scope.instagram = false;
	$scope.idCategorySearch= $routeParams.idCategorySearch;
	$http({
		method : "GET",
		url : "models/promotions.php?acc=l"
	}).then(function mySucces (response) {
		$scope.data=response.data;
		$scope.promos=$scope.data[0].promotions;
		$scope.filters=$scope.data[0].filters;
		$scope.web=$scope.data[0].web[0].urlWeb;
		}, function myError (response) {
		$scope.data = response.statusText;
		console.log("filtros: "+$scope.filters);
	})
	.finally (function(){
		$scope.loading=false;
	});

});

angular.module('spaApp')
.controller('PromotionCtrl', function($scope, $http, $routeParams) {
		$scope.loading=true;
		$http({
			method : "GET",
			url : "models/promotions.php?acc=s&idPromo=" + $routeParams.idPromotion
		}).then(function mySucces (response) {
			$scope.shops = response.data[0];
    		if($scope.shops.promotion[0].userWa != "") $scope.service = true;
		    if($scope.shops.promotion[0].userFb != "") $scope.facebook = true;
			if($scope.shops.promotion[0].userTt != "") $scope.twitter = true;
		    if($scope.shops.promotion[0].userIg != "") $scope.instagram = true;
			$scope.promoSelArray=response.data;
			$scope.promoSel=$scope.promoSelArray[0].promotion;
			$scope.web=$scope.promoSelArray[0].web[0].urlWeb;

		}, function myError (response) {
			$scope.promoSel = response.statusText;
		})
		.finally (function(){
			$scope.loading=false;
		});
});