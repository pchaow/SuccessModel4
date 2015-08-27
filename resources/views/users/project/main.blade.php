@extends('users.layout')

@section('header')
    <style>
        .videoWrapper {
            position: relative;
            padding-bottom: 56.25%; /* 16:9 */
            padding-top: 25px;
            height: 0;
        }
        .videoWrapper iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
        }
    </style>

    <link rel="stylesheet" type="text/css" href="/packages/flexslider/flexslider.css">
@stop



@section('content')
    <div ng-app="UsersProject">
        <div ng-controller="loadCtrl" ng-class="{active:active}" class="ui inverted dimmer ">
            <div class="ui large text loader">
                Loading
            </div>
        </div>

        <ui-view>

        </ui-view>
    </div>

@stop


@section('javascript')
    <script type="text/javascript" src="/packages/flexslider/jquery.flexslider-min.js"></script>
    <script type="text/javascript" src="/packages/angular-flexslider/angular-flexslider.js"></script>
    <script type="text/javascript" src="/packages/showdown/compressed/Showdown.js"></script>
    <script type="text/javascript" src="/packages/angular-sanitize/angular-sanitize.min.js"></script>
    <script type="text/javascript" src="/packages/angular-markdown-directive/markdown.js"></script>
    <script type="text/javascript" src="/packages/bxslider/jquery.bxSlider.min.js"></script>
    <script type="text/javascript" src="/app/university/UniversityService.js"></script>
    <script type="text/javascript" src="/app/admin/YoutubeService.js"></script>
    <script type="text/javascript" src="/app/admin/UserService.js"></script>
    <script type="text/javascript" src="/app/admin/ProjectService.js"></script>
    <script type="text/javascript" src="/app/users/UsersService.js"></script>
    <script src="/app/admin/loader.js"></script>
    <script src="/app/users/project/app.js"></script>

@stop