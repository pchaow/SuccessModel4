/**
 * Created by chaow on 4/7/2015.
 */

angular.module('University',[])
    .factory('UniversityService',function($http){
        return {
            all: function () {
                return $http.get('/api/project');
            },
            getProjects : function (){
                return $http({
                    url : '/api/university/projects',
                    method : 'get'
            })
        },
            submit : function($id,$project){
                return $http({
                    url : '/api/university/submit-project/'+$id,
                    method: 'post',
                    data : $project
                })
            },
            rejectProject : function($id,$project){
                return $http({
                    url : '/api/university/reject-project/'+ $id,
                    method : 'post',
                    data : $project
                })
            },
            get :  function($id,$project){
                return $http({
                    url : '/api/university/get-project/'+ $id,
                    method : 'get',
                    data : $project
                })
            }
        }

    })