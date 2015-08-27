/**
 * Created by chaow on 4/7/2015.
 */

angular.module('Area',[])
    .factory('AreaService',function($http){
        return {
            all : function(){
                return $http.get('/api/area');
            },
            index: function () {
                return $http({
                    url: '/api/area',
                    method: 'get'
                })
            },
            getID: function () {
                return $http({
                    url: '/api/area/get/'+$id,
                    method: 'get'
                })
            },
            addArea: function ($project) {
                return $http({
                    url: '/api/area/add',
                    method: 'post',
                    data : $project
                })
            },
            delete : function(area){
                return $http.delete('/api/area/' + area.id);
            },
            update: function () {
                return $http({
                    url: '/api/area/update',
                    method: 'get'
                })
            }
        }
    })