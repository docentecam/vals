angular.module('spaApp')
.controller('ShopCtrl', function($scope, $http, $routeParams) {
  $scope.loading = true;
  $scope.service = false;
  $scope.facebook = false;
  $scope.twitter = false;
  $scope.instagram = false;
	$http({
		method : "GET",
		url : "models/shops.php?acc=shop&idShop="+$routeParams.idShop
	}).then(function mySucces(response) {
		$scope.shops = response.data[0];
    if($scope.shops["userWa"] != "") $scope.service = true;
    if($scope.shops.userFb != "") $scope.facebook = true;
    if($scope.shops.userTt != "") $scope.twitter = true;
    if($scope.shops.userIg != "") $scope.instagram = true;
	}, function myError(response) {
		$scope.shops = response.statusText;
	}).finally(function(){
      $scope.loading = false;
  });

  // $scope.loading = true;
  // $http({
  //   method : "GET",
  //   url : "models/xmlCreation.php?acc=shop&idShop="+$routeParams.idShop
  // }).then(function mySucces (response) {
  //   $scope.categories=response.data;
  // }, function myError (response) {
  //   $scope.categories = response.statusText;
  // }).finally(function(){
  //     $scope.loading = false;
  // });
});