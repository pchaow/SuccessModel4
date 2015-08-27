/**
 * Created by chaow on 4/12/2015 AD.
 */

function getParameterByName(url, name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(url);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

function doPopup() {
    $('.button').popup({
        inline: true,
    });
}


angular.module('AppConfig', [])
    .config(function ($httpProvider, $provide) {
        $provide.factory('httpInterceptor', function ($q, $rootScope) {
            return {
                'request': function (config) {
                    // intercept and change config: e.g. change the URL
                    // config.url += '?nocache=' + (new Date()).getTime();
                    // broadcasting 'httpRequest' event
                    $rootScope.$broadcast('httpRequest', config);
                    return config || $q.when(config);
                },
                'response': function (response) {
                    // we can intercept and change response here...
                    // broadcasting 'httpResponse' event
                    $rootScope.$broadcast('httpResponse', response);
                    return response || $q.when(response);
                },
                'requestError': function (rejection) {
                    // broadcasting 'httpRequestError' event
                    $rootScope.$broadcast('httpRequestError', rejection);
                    return $q.reject(rejection);
                },
                'responseError': function (rejection) {
                    // broadcasting 'httpResponseError' event
                    $rootScope.$broadcast('httpResponseError', rejection);
                    return $q.reject(rejection);
                }
            };
        });
        $httpProvider.interceptors.push('httpInterceptor');
    })
    .controller('loadCtrl', function ($scope, $timeout) {

        $scope.active = false;

        var self = this;
        self.request_count = 0;

        self.response = function () {
            self.request_count--;
            if (self.request_count == 0) {
                $timeout(function () {
                    $scope.active = false;
                    initialResizeWindows();
                }, 300)

            }
        }

        $scope.$on('httpRequest', function (e) {
            $scope.active = true;
            self.request_count++;
            //console.log(self.request_count);
        });
        $scope.$on('httpResponse', function (e) {
            self.response();
        });
        $scope.$on('httpRequestError', function (e) {
            self.response();
        });
        $scope.$on('httpResponseError', function (e) {
            self.response();
        });

    })

