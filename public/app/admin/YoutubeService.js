/**
 * Created by chaow on 4/7/2015.
 */

angular.module('Youtube', [])
    .value('api_key', 'AIzaSyCyb1w6ezK3C0k64_1AiB0vK-qjmQkCrcI')
    .factory('YoutubeService', function ($http,api_key) {
        return {
            getVideoDetail : function(vid){
                return $http.get('https://www.googleapis.com/youtube/v3/videos?part=snippet&id='+vid+'&key='+api_key+'')
            }


        }
    })