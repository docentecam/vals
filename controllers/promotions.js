angular.module('spaApp')
.controller('PromotionsCtrl', function($scope, $http) {
	$scope.list = true;
	$scope.loading=true;
	$scope.idCategorySearch="";

	$http({
		method : "GET",
		url : "models/promotions.php?acc=l"
	}).then(function mySucces (response) {
		$scope.data=response.data;
		$scope.promos=$scope.data[0].promotions;
		$scope.filters=$scope.data[0].filters;
		$scope.web=$scope.data[0].web[0].urlWeb;
		console.log($scope.promos);
		console.log($scope.data[0].web[0].urlWeb);
	}, function myError (response) {
		$scope.data = response.statusText;
	})
	.finally (function(){
		$scope.loading=false;
	});

	$scope.filterCat = function(idCategory)
	{
		$scope.idCategorySearch=idCategory;
	}

	$scope.searchOffer = function(idPromo)
	{
		console.log (idPromo);
		$http({
			method : "GET",
			url : "models/promotions.php?acc=s&idPromo=" + idPromo
		}).then(function mySucces (response) {
			$scope.promoSel=response.data;
			console.log($scope.promoSel);
			$scope.list = false;
		}, function myError (response) {
			$scope.promoSel = response.statusText;
		})
		.finally (function(){
			$scope.loading=false;
		});

	}


});