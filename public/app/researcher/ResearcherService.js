/**
 * Created by chaow on 4/7/2015.
 */

angular.module('Researcher',[])
    .factory('ResearcherService',function($http){
        return {
            all: function () {
                return $http.get('/api/project');
            },
            getProjects : function (){
                return $http({
                    url : '/api/researcher/projects',
                    method : 'get'
            })
        },
            addProject : function($project){
                return $http({
                    url : '/api/researcher/add-project',
                    method: 'post',
                    data : $project
                })
            },
            submit : function($id,$project){
                return $http({
                    url : '/api/researcher/submit-project/'+ $id,
                    method : 'post',
                    data : $project
                })
            },
            get : function($id,$project){
                return $http({
                    url : '/api/researcher/get-project/'+ $id,
                    method : 'get',
                    data : $project
                })
            },
            update : function ($id,$project){
                return $http({
                    url : '/api/researcher/update-project/'+ $id,
                    method : 'post',
                    data : $project
                })
            },
            getMembers: function ($id) {
                return $http({
                    url: '/api/project/' + $id + '/member',
                    method: 'get'
                })
            },
            addMember: function ($id, $user) {
                return $http({
                    url: '/api/project/' + $id + '/member',
                    method: 'post',
                    data: $user
                })
            },
            deleteMember: function ($id, $user) {
                return $http({
                    url: '/api/project/' + $id + '/member/' + $user.id,
                    method: 'delete',
                    data: $user
                })
            },
            getImages: function ($id) {
                return $http({
                    url: '/api/project/' + $id + '/image',
                    method: 'get'
                })
            },
            addImage: function ($id, $image) {
                return $http({
                    url: '/api/project/' + $id + '/image',
                    method: 'post',
                    data: $image
                })
            },
            deleteImage: function ($id, $image) {
                return $http({
                    url: '/api/project/' + $id + '/image/' + $image.id,
                    method: 'delete',
                    data: $image
                })
            },
            getFile: function ($id) {
                return $http({
                    url: '/api/project/' + $id + '/file',
                    method: 'get'
                })
            },
            getPreviousFiles: function ($id) {
                return $http({
                    url: '/api/project/' + $id + '/previous-files',
                    method: 'get'
                })
            },
            addFile: function ($id, $file) {
                return $http({
                    url: '/api/project/' + $id + '/file',
                    method: 'post',
                    data: $file
                })
            },
            deleteFile: function ($id, $file) {
                return $http({
                    url: '/api/project/' + $id + '/file/' + $file.id,
                    method: 'delete',
                    data: $file
                })
            },
            getYoutubes : function($id){
                return $http({
                    url: '/api/project/' + $id + '/youtube',
                    method: 'get'
                })
            },
            addYoutube: function ($id, $youtube) {
                return $http({
                    url: '/api/project/' + $id + '/youtube',
                    method: 'post',
                    data: $youtube
                })
            },
            deleteYoutube: function ($id, $youtube) {
                return $http({
                    url: '/api/project/' + $id + '/youtube/' + $youtube.id,
                    method: 'delete',
                    data: $youtube
                })
            },
            delete: function (project) {
                return $http.delete('/api/project/' + project.id);
            }

        }


    })