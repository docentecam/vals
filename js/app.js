var app= angular.module('spaApp', ['ngRoute']);
app.config(['$routeProvider', function ($routeProvider) {
    $routeProvider
    .when('/', {
        templateUrl: 'views/inicio.html',
    })
    // .when('/promotion/:idPromotion', {
    //     templateUrl: 'views/promotions.html',
    //     controller: 'PromotionCtrl',
    // })
    .when('/promotion/:idPromotion', {
        templateUrl: 'views/promotion.html',
        controller: 'PromotionCtrl',
    })
    .otherwise({
        redirectTo: '/'
    });
}]); 