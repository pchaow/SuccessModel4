/**
 * Created by chaow on 4/7/2015.
 */

var app = angular.module('ApiKeyAdmin', ['ui.router','AppConfig','angularify.semantic', 'flow', 'ApiKey']);

app.config(function ($stateProvider, $urlRouterProvider) {

    $urlRouterProvider.otherwise("/");

    $stateProvider
        .state('home', {
            url: "/",
            templateUrl: "/app/admin/apikey/_home.html",
            controller: "HomeCtrl",
            controllerAs: "self",
            resolve: {
                keys: function (ApiKeyService) {
                    return ApiKeyService.all();
                }
            }
        })
});

app.controller("HomeCtrl", function ($scope, $state, keys, ApiKeyService) {
    console.log("HomeCtrl Start...");

    var self = this;
    self.keys = keys.data;

    self.generate = function(){
        ApiKeyService.generate()
            .success(function(resposne){
                self.keys.push(resposne);
            });
    }

    self.showDeleteModal = function (key) {
        self.key = key;
        self.delete_modal = true;
    }

    self.closeDeleteModal = function () {
        self.delete_modal = false;
    }

    self.ajaxDelete = function (key, bool) {
        self.key = key;
        if (bool) {
            ApiKeyService.delete(key).success(function (response) {
                self.closeDeleteModal();
                ApiKeyService.all().success(function (response) {
                    self.keys = response;
                })
            });
        } else {
            self.closeDeleteModal();
        }

    }


});
