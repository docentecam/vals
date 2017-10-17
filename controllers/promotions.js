angular.module('spaApp')															 
.controller('PromotionsCtrl', function($scope, $http) {
	$scope.textProva="Texte del controler";
/*$http({
		method : "GET",
		url : "models/links.php?acc=links"
	}).then(function mySucces (response) {
		$scope.links=response.data;
	}, function myError (response) {
		$scope.links = response.statusText;
	});
	*/
});		