<!DOCTYPE HTML>
<html>
<head>
    <meta name="csrf_token" value="<?php echo csrf_token(); ?>">
    <link rel="stylesheet" href="/packages/semantic/dist/semantic.min.css"/>
    <link rel="stylesheet" href="/packages/semantic/dist/components/dropdown.min.css"/>

    <script src="/packages/jquery/dist/jquery.min.js"></script>
    <script src="/packages/semantic/dist/semantic.min.js" type="text/javascript"></script>
    <script src="/packages/semantic/dist/components/dropdown.min.js" type="text/javascript"></script>
    <style>
        .avatar-menu {
            height: 2em !important;
            width: 2em !important;
            margin-top: -0.5em;
            margin-bottom: -0.5em;
        }

        .ui.inverted.purple.segment {
            background-color: #4c1d6e !important;
        }
    </style>

    @yield('header')


</head>

<body>

<div class="ui grid">
    <div class="one column row" style="padding-bottom: 0px;">
        <div class="column" style="background-color: #4c1d6e">
            <div class="ui grid container">
                <div class="column">
                    <h2 class="ui header inverted" style="padding: 10px;">
                        <img src="/images/uplogo.png">

                        <div class="content">
                            Success Model
                            <div class="sub header">ระบบฐานข้อมูลโครงการหนึ่งคณะหนึ่งโมเดล</div>
                        </div>
                    </h2>
                </div>
            </div>
        </div>
        <div class="column">
            <div class="ui container">
                <div class="ui large stackable menu " id="MainMenu" style="border-radius: 0px;">

                    <a id="main-sidebar-btn" class="item">
                        <i class="sidebar icon"></i>
                        Menu
                    </a>
                    <a class="item ">
                        User
                    </a>
                    <div class="right aligned right floated column">
                        <a class="item active">
                            <div class="ui icon input">
                                <input type="text" placeholder="Search...">
                                <i class="circular search icon"></i>
                             </div>
                        </a>
                    </div>
                    <a class="item ">
                        <button class="ui orange button" href="/auth/login">Login</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="ui grid" style="margin-top: 0px;">
    <div class="one column row">
        <div class="column">
            <div id="main-content" class="pushable" style="min-height: 480px;">
                <div id="main-sidebar" class="ui inverted labeled vertical sidebar menu">
                    @yield('sidemenu')
                </div>
                <div class="pusher" style="min-height: inherit;">
                    <div class="ui container">
                        <div class="column">
                            @yield('content')
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="ui centered padded grid" style="">

    <div class="column" style="text-align: left">
        © 2015 University of Phayao. ALL Rights Reserved
    </div>
</div>
<script type="text/javascript">
    $('.ui.dropdown').dropdown();

    $('#main-sidebar')
            .sidebar({
                context: $('#main-content'),
                transition: 'push'
            })
    ;

    $('#main-sidebar-btn').bind('click', function () {
        $('#main-sidebar').sidebar('toggle');
    })

</script>

@include('admin.js')

<script type="text/javascript">
    angular.module("MainMenuApp", ['AppConfig'])
            .controller("UserCtrl", function ($scope, $http) {
                $scope.current_user = {};
                console.log("UserCtrl MainMenuApp Start...")

//                $http.get('/api/auth/user').success(function (response) {
//                    $scope.current_user = response;
//                })

                $scope.logout = function () {
                    var logout = $http.get('/api/auth/user');

                    logout.success(function () {
                        window.location = '/auth/login';
                    })
                }
            })

    angular.bootstrap($("#MainMenu"), ['MainMenuApp']);

</script>

@yield('javascript')


</body>
</html>