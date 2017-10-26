var app= angular.module('spaApp', ['ngRoute']);
app.config(['$routeProvider', function ($routeProvider) {
    $routeProvider
    .when('/', {
        templateUrl: 'views/inicio.html',
        controller: 'PromotionsCtrl',
    })

    // .otherwise({
    //     redirectTo: '/'
    // });
}]); 