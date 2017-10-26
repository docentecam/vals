angular.module('spaApp')
.controller('PromotionsCtrl', function($scope, $http) {
	$scope.loading=true;

$http({
		method : "GET",
		url : "models/promotions.php?acc=l"
	}).then(function mySucces (response) {
		$scope.promos=response.data;
	}, function myError (response) {
		$scope.promos = response.statusText;
	})
	.finally (function(){
		$scope.loading=false;
		
	});
	console.log($scope.promos);
	console.log("Prueba");
});