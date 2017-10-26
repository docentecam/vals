angular.module('spaApp')
.controller('PromotionsCtrl', function($scope, $http) {
	$scope.list = true;
	$scope.loading=true;

	$http({
		method : "GET",
		url : "models/promotions.php?acc=l"
	}).then(function mySucces (response) {
		$scope.promos=response.data;
		console.log($scope.promos);
	}, function myError (response) {
		$scope.promos = response.statusText;
	})
	.finally (function(){
		$scope.loading=false;
	});

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