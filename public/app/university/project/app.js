/**
 * Created by tiwter on 6/10/2015.
 */


var app = angular.module('UniversityProject', ['ui.router', 'AppConfig', 'User', 'University',
    'Youtube','Project' , 'angularify.semantic', 'flow', 'ngCookies', 'btford.markdown']);

app.config(function ($stateProvider, $urlRouterProvider) {

    $urlRouterProvider.otherwise("/");

    $stateProvider
        .state('home', {
            url: "/",
            templateUrl: "/app/university/project/_home.html",
            controller: "HomeCtrl",
            resolve: {
                projects: function (UniversityService) {
                    return UniversityService.getProjects();
                }
            }
        })

        .state('view', {
            url: "/view/:id",
            templateUrl: "/app/university/project/_view.html",
            controller: "ViewCtrl",
            resolve: {
                project: function (UniversityService,$stateParams) {
                return UniversityService.get($stateParams.id)
            },
            images: function (ProjectService, $stateParams) {
                return ProjectService.getImages($stateParams.id);
            },
            members: function (ProjectService, $stateParams) {
                return ProjectService.getMembers($stateParams.id);
            },
            file: function (ProjectService, $stateParams) {
                return ProjectService.getFile($stateParams.id);
            },
            previousFiles: function (ProjectService, $stateParams) {
                return ProjectService.getPreviousFiles($stateParams.id);
            },
            youtubes: function (ProjectService, $stateParams) {
                return ProjectService.getYoutubes($stateParams.id);
            }
        }
        })
});

app.controller("HomeCtrl", function ($scope,$timeout,projects,$state,UniversityService) {
    console.log("HomeCtrl Start...");
    $scope.projects = projects.data;
    $scope.reject_modal = false;
    $scope.accept_modal = false;


    $scope.showRejectModal = function (project) {
        $scope.project = project;
        $scope.reject_modal = true;
    }

    $scope.closeRejectModal = function () {
        $scope.reject_modal = false;
    }


    $scope.ajaxReject = function (project, bool) {
        $scope.project = project;
        if (bool) {
            UniversityService.rejectProject($scope.project.id,$scope.project).success(function (response) {
                $scope.closeRejectModal();
                UniversityService.getProjects().success(function (response) {
                    $scope.projects = response;
                })
                $state.go('home');
            });
        } else {
            $scope.closeRejectModal();
        }

    }



    $scope.showAcceptModal = function (project) {
        $scope.project = project;
        $scope.accept_modal = true;
    }

    $scope.closeAcceptModal = function () {
        $scope.accept_modal = false;
    }

    $scope.ajaxAccept = function (project, bool) {
        $scope.project = project;
        if (bool) {
            UniversityService.submit($scope.project.id,$scope.project).success(function (response) {
                $scope.closeAcceptModal();
                UniversityService.getProjects().success(function (response) {
                    $scope.projects = response;
                })
                $state.go('home');
            });
        } else {
            $scope.closeAcceptModal();
        }

    }

    $timeout(doPopup,200);




});

app.controller("ViewCtrl", function ($scope, $state, $timeout, $sce,
                                     UserService, UserSearchService, ProjectService,UniversityService,
                                     project, images, members, file, previousFiles, youtubes) {
    console.log("ViewCtrl Start...");

    $scope.project = project.data;
    $scope.images = images.data;
    $scope.youtubes = youtubes.data;
    $scope.project.content = $sce.trustAsHtml($scope.project.content);
    $scope.showItem = null;
    $scope.members = members.data;
    $scope.setShowItem = function (item, type) {
        $scope.showItem = {item: item, type: type}
    }

    $scope.getYoutubeEmbedUrl = function (vid) {
        return $sce.trustAsResourceUrl('http://www.youtube.com/embed/' + vid + '?autoplay=0&enablejsapi=1&version=3&playerapiid=ytplayer');
    }

    if ($scope.youtubes.length > 0) {
        $scope.setShowItem($scope.youtubes[0], 'youtube');
    } else if ($scope.images.length > 0) {
        $scope.setShowItem($scope.images[0], 'image');
    } else {
        $scope.showItem = null;
    }
    $timeout(function(){
        $('.flexslider').flexslider({
            slideshow: true,
            video : true,
            before: function(slider){
                /* ------------------  YOUTUBE FOR AUTOSLIDER ------------------ */
                playVideoAndPauseOthers($('.play3 iframe')[0]);
            }
        });

        function playVideoAndPauseOthers(frame) {
            $('iframe').each(function(i) {
                var func = this === frame ? 'playVideo' : 'stopVideo';
                this.contentWindow.postMessage('{"event":"command","func":"' + func + '","args":""}', '*');
            });
        }

        /* ------------------ PREV & NEXT BUTTON FOR FLEXSLIDER (YOUTUBE) ------------------ */
        $('.flex-next, .flex-prev').click(function() {
            playVideoAndPauseOthers($('.play3 iframe')[0]);
        });
    },10)

    $scope.showRejectModal = function (project) {
        $scope.project = project;
        $scope.reject_modal = true;
    }

    $scope.closeRejectModal = function () {
        $scope.reject_modal = false;
    }


    $scope.ajaxReject = function (project, bool) {
        $scope.project = project;
        if (bool) {
            UniversityService.rejectProject($scope.project.id,$scope.project).success(function (response) {
                $scope.closeRejectModal();
                UniversityService.all().success(function (response) {
                    $scope.projects = response;
                })
                $state.go('home');
            });
        } else {
            $scope.closeRejectModal();
        }

    }



    $scope.showAcceptModal = function (project) {
        $scope.project = project;
        $scope.accept_modal = true;
    }

    $scope.closeAcceptModal = function () {
        $scope.accept_modal = false;
    }

    $scope.ajaxAccept = function (project, bool) {
        $scope.project = project;
        if (bool) {
            UniversityService.submit($scope.project.id,$scope.project).success(function (response) {
                $scope.closeAcceptModal();
                UniversityService.all().success(function (response) {
                    $scope.projects = response;
                })
                $state.go('home');
            });
        } else {
            $scope.closeAcceptModal();
        }

    }

});


app.controller("ProjectMemberCtrl", function ($scope, $stateParams, $state, $timeout,
                                              UserSearchService, UserService, ProjectService) {

    var self = this;
    self.firstInit = false;
    $scope.initProjectMemberCtrl = function () {
        console.log("ProjectMemberCtrl Start...")
        if (self.firstInit) {
            ProjectService.getMembers($stateParams.id).success(function (resposne) {
                self.projectMembers = resposne;
            });
        } else {
            self.projectMembers = $scope.projectMembers
        }

        self.firstInit = true;
    }

    $scope.initProjectMemberCtrl();

    self.member = UserSearchService.getSearchAjax();
    self.member.addMember = function (user) {

    }

    self.member.addMember = function (user) {
        ProjectService.addMember($scope.project.id, user)
            .success(function (response) {
                //console.log(response);
                //alert('view console');
                self.projectMembers.push(response);
            })
    }

    self.member.removeMember = function (user) {
        console.log(user);
        ProjectService.deleteMember($scope.project.id, user)
            .success(function (response) {
                //console.log(response);
                //alert('view console');
                var index = self.findUser(user);
                if (index != -1) {
                    self.projectMembers.splice(index, 1);
                }
            })
    }

    self.findUser = function (user) {
        var countUsers = self.projectMembers.length;
        var i = 0;
        for (i = 0; i < countUsers; i++) {
            if (self.projectMembers[i].id === user.id) {
                return i;
            }
        }
        return -1;
    }

    self.checkUser = function ($user) {
        var countUsers = self.projectMembers.length;
        var i = 0;
        for (i = 0; i < countUsers; i++) {
            if (self.projectMembers[i].id === $user.id) {
                return true;
            }
        }
        return false;
    }

});

app.controller("ProjectPhotoController", function ($scope, $state, $cookies, $timeout,
                                                   UserService, ProjectService) {

    var self = this;
    self.firstInit = false;
    $scope.initProjectPhotoController = function () {
        console.log("ProjectPhotoController Start...");
        self.project = $scope.project;
        self.images = [];

        self.myFlow = new Flow({
            target: '/api/project/' + self.project.id + '/image',
            singleFile: false,
            method: 'post',
            testChunks: false,
            headers: function (file, chunk, isTest) {
                return {
                    'X-XSRF-TOKEN': $cookies.get('XSRF-TOKEN')// call func for getting a cookie
                }
            }
        })

        self.loadImages();
        self.firstInit = true;
    }

    self.loadImages = function () {
        if (self.firstInit) {
            ProjectService.getImages(self.project.id)
                .success(function (response) {
                    self.images = response;
                    //console.log(response);
                })
        } else {
            self.images = $scope.images;
        }

    };


    self.uploadFiles = function () {
        console.log("do uploading");
        self.myFlow.upload();
    }

    self.addFileToList = function ($file, $message, $flow) {
        //console.log($file);
        //console.log($message);

        var file = JSON.parse($message);
        self.images.push(file);
        $flow.removeFile($file);
    }

    self.deleteImage = function (image) {

        if (confirm("Do you want to delete this image")) {
            ProjectService.deleteImage(self.project.id, image)
                .success(function (response) {
                    var i = 0;
                    var index = -1;

                    for (i = 0; i < self.images.length; i++) {
                        if (self.images[i].id == image.id) {
                            index = i;
                            break;
                        }
                    }
                    if (index != -1) {
                        self.images.splice(index, 1);
                    }
                })
        }

    }

    $scope.initProjectPhotoController();

});

app.controller("ProjectFileController", function ($scope, $state, $cookies, $timeout,
                                                  ProjectService) {

    var self = this;
    self.firstInit = false;
    self.file = {};
    $scope.initProjectFileController = function () {
        console.log("ProjectFileController Start...");
        self.project = $scope.project;
        if (self.firstInit) {
            ProjectService.getFiles($stateParams.id)
                .success(function (response) {
                    self.files = response;
                })
        } else {
            self.file = $scope.file
            self.previousFiles = $scope.previousFiles;
        }


        self.myFlow = new Flow({
            target: '/api/project/' + self.project.id + '/file',
            singleFile: true,
            method: 'post',
            testChunks: false,
            headers: function (file, chunk, isTest) {
                return {
                    'X-XSRF-TOKEN': $cookies.get('XSRF-TOKEN')// call func for getting a cookie
                }
            }
        });

        self.uploadFiles = function () {
            console.log("do uploading");
            self.myFlow.upload();
        };

        self.addFileToList = function ($file, $message, $flow) {
            console.log('add file to list');
            var file = JSON.parse($message);
            if ($scope.file) {
                self.previousFiles.splice(0, 0, $scope.file);
            }
            self.file = file;
            $scope.file = file;
            $flow.removeFile($file);
        };

        self.firstInit = true;
    };

    $scope.initProjectFileController();
});

app.controller("ProjectYoutubeController", function ($scope, $state, $cookies, $timeout,
                                                     ProjectService, YoutubeService) {

    var self = this;
    self.firstInit = false;
    self.youtubes = [];
    self.youtube = {};
    $scope.initProjectYoutubeController = function () {
        console.log("ProjectYoutubeController Start...");
        self.project = $scope.project;
        if (self.firstInit) {
            ProjectService.getYoutubes($stateParams.id)
                .success(function (response) {
                    self.youtubes = response;
                    self.youtube = [];
                })
        } else {
            self.youtubes = $scope.youtubes;
            console.log($scope.youtubes);
        }

    };

    self.validYT = function (url) {
        var p = /^(?:https?:\/\/)?(?:www\.)?youtube\.com\/watch\?(?=.*v=((\w|-){11}))(?:\S+)?$/;
        return (url.match(p)) ? RegExp.$1 : false;
    }

    self.addYoutube = function () {

        if (self.validYT(self.youtube.url)) {


            var vid = self.getParameterByName(self.youtube.url, 'v');

            YoutubeService.getVideoDetail(vid)
                .success(function (response) {
                    var result = response;
                    var vidsnipplet = result.items[0].snippet;
                    var title = vidsnipplet.title;
                    var description = vidsnipplet.description;

                    var thumbnail = vidsnipplet.thumbnails.default.url

                    self.youtube.title = title;
                    self.youtube.thumbnail_url = thumbnail;
                    self.youtube.description = description;
                    self.youtube.vid = vid;
                    console.log(self.youtube);

                    ProjectService.addYoutube(self.project.id, self.youtube)
                        .success(function (resposne) {
                            self.youtubes.push(resposne);
                            self.youtube = null;
                        })
                })
        } else {
            alert('Please enter valid youtube url.');
        }

    }

    self.deleteYoutube = function (youtube) {
        ProjectService.deleteYoutube(self.project.id, youtube)
            .success(function (response) {
                var i;
                for (i = 0; i < self.youtubes.length; i++) {
                    if (self.youtubes[i].id == youtube.id) {
                        self.youtubes.splice(i, 1);
                        break;
                    }
                }
            })
    }

    self.getParameterByName = function (url, name) {
        name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
        var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
            results = regex.exec(url);
        return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
    };


    $scope.initProjectYoutubeController();
});


