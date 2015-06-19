<!DOCTYPE HTML>
<html>
<head>
    <meta name="csrf_token" value="<?php echo csrf_token(); ?>">
    <link rel="stylesheet" href="/packages/semantic-ui/dist/semantic.min.css"/>
    <link rel="stylesheet" href="/packages/semantic-ui/dist/components/dropdown.min.css"/>

    <script src="/packages/jquery/dist/jquery.min.js"></script>
    <script src="/packages/semantic-ui/dist/semantic.min.js" type="text/javascript"></script>
    <script src="/packages/semantic-ui/dist/components/dropdown.min.js" type="text/javascript"></script>
    <style>
        .avatar-menu {
            height: 2em !important;
            width: 2em !important;
            margin-top: -0.5em;
            margin-bottom: -0.5em;
        }
    </style>

    @yield('header')


</head>

<body>

<div class="ui" style="background-color: #4c1d6e">

    <h2 class="ui header inverted" style="padding: 10px;">
        <img src="/images/uplogo.png">

        <div class="content">
            Success Model
            <div class="sub header">ระบบฐานข้อมูลโครงการหนึ่งคณะหนึ่งโมเดล</div>
        </div>
    </h2>

</div>

<div class="ui">
    <div class="row">
        <div class="ui large menu " id="MainMenu">
            <div class="left purple inverted menu">
                <a class="item active">
                    <%$role_name%>
                </a>
                <a class="item">
                    About Us
                </a>
            </div>

            <div class="right menu">
                <div class="item ui dropdown" ng-controller="UserCtrl">
                    @if(Auth::user()->logo)
                        <img class="ui avatar avatar-menu image" src="<%Auth::user()->logo->url%>?h=200">
                    @else
                        <img class="ui avatar avatar-menu image" src="/images/square-image.png">
                    @endif
                    @if(Auth::user())
                        <span><%Auth::user()->email%></span>
                    @endif
                    <div class="menu">
                        <div class="header">
                            <i class="tags icon"></i>
                            เลือกสิทธิ์การใช้งาน
                        </div>
                        @foreach( Auth::user()->roles as $role)
                            <a class=" <% Request::is("$role->key/*") ? 'active' : '' %> item" href="/<%$role->key%>">
                                <% $role->name %>
                            </a>
                        @endforeach
                        <div class="divider"></div>
                        <a class="item">Change Profile</a>
                        <a class="item" ng-click="logout()">Logout</a>
                    </div>


                </div>

                <div class="item">
                    Support
                </div>
                <a class="item">
                    FAQ
                </a>
                <a class="item">
                    E-mail Support
                </a>
            </div>
        </div>
    </div>

</div>


<div class="ui padded stackable grid">
    <div class="ui row">
        <div class="ui three wide column">
            @yield('sidemenu')
        </div>
        <div class="ui thirteen wide column">
            @yield('content')
        </div>
    </div>
</div>


<script type="text/javascript">
    $('.ui.dropdown').dropdown();
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