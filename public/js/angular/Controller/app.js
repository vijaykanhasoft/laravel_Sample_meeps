var app = angular.module('myapp', ['ngRoute', 'ngCookies', 'ui.router', 'ui.bootstrap', 'ui.utils', 'datatables', 'datatables.bootstrap', 'ngSanitize']);
app.config(['$stateProvider', '$urlRouterProvider', '$interpolateProvider',
    function ($stateProvider, $urlRouterProvider, $interpolateProvider) {
        $urlRouterProvider.otherwise("/user-management");
        $interpolateProvider.startSymbol('{[{').endSymbol('}]}');
        $stateProvider.
                state('/user-management', {
                    url: '/user-management',
                    templateUrl: 'resources/views/user-management.html',
                    controller: 'frontCtrl',
                    headeruse: 'no'
                })
    }]);


app.run(['$rootScope', function ($rootScope) {
        var hash = window.location.hash.substr(1);
        $rootScope.current_page = hash;
    }]);