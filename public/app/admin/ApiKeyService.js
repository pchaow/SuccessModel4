/**
 * Created by chaow on 4/7/2015.
 */

angular.module('ApiKey',[])
    .factory('ApiKeyService',function($http){
        return {
            all : function() {
                return $http.get('/api/api-key');
            },
            generate : function() {
                return $http.post('/api/api-key');
            },
            delete: function (key) {
                return $http.delete('/api/api-key/' + key.id);
            },


        }
    })