/**
 * Created by chaow on 4/7/2015.
 */

angular.module('Faculty',[])
    .factory('FacultyService',function($http){
        return {
            all: function () {
                return $http.get('/api/project');
            },
            getProjects : function (){
                return $http({
                    url : '/api/faculty/projects',
                    method : 'get'
            })
        },
            submit : function($id,$project){
                return $http({
                    url : '/api/faculty/submit-project/'+$id,
                    method: 'post',
                    data : $project
                })
            },
            rejectProject : function($id,$project){
                return $http({
                    url : '/api/faculty/reject-project/'+ $id,
                    method : 'post',
                    data : $project
                })
            },
            get :function($id,$project){
                return $http ({
                    url:'api/faculty/get-project/'+ $id,
                    method : 'get',
                    data: $project
                })
            }
        }

    })