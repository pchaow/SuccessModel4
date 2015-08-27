/**
 * Created by tiwter on 6/10/2015.
 */


var app = angular.module('UsersProject', ['ui.router', 'AppConfig','Users','Project',
    'angularify.semantic', 'flow', 'ngCookies', 'btford.markdown']);

app.config(function ($stateProvider, $urlRouterProvider) {

    $urlRouterProvider.otherwise("/");

    $stateProvider
        .state('home', {
            url: "/",
            templateUrl: "/app/users/project/_home.html",
            controller: "HomeCtrl",
            resolve: {
                projects: function (UsersService) {
                    return UsersService.all();
                }
            }
        })
    });

app.controller("HomeCtrl", function ($scope,projects) {
    console.log("HomeCtrl Start...");
    $scope.projects = projects.data;


});

