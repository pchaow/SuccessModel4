<!DOCTYPE HTML5>
<html>
<head>
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
</head>

<body ng-app="MainApp">

<div class="ui grid">
    <div class="one column row">
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
    </div>
</div>

<div class="ui middle aligned center aligned grid">
    <div class="column" style="max-width: 450px;">
        <div ng-controller="loadCtrl" ng-class="{active:active}" class="ui inverted dimmer ">
            <div class="ui large text loader">
                Loading
            </div>
        </div>

        <div ng-controller="LoginCtrl">

            <div class="ui top attached purple inverted  segment">
                <h4>เข้าใช้งานระบบ / Sign in</h4>
            </div>
            <div class="ui attached segment" ng-if="message">
                <div class="ui negative message">
                    <div class="header">We had some issues</div>
                    <ul class="list" ng-if="message">
                        <li ng-repeat="m in message" ng-bind="m"></li>
                    </ul>
                </div>
            </div>
            <div class="ui attached segment" ng-if="!loginComplete">
                <form class="ui form" ng-submit="login()">
                    <div class="ui field">
                        <label>Username or E-Mail</label>

                        <div class="ui left icon input">
                            <i class="mail icon"></i>
                            <input ng-model="user.email" name="email" type="text" placeholder="Username & E-Mail">
                        </div>

                    </div>
                    <div class="ui field">
                        <label>Password</label>

                        <div class="ui left icon input">
                            <i class="lock icon"></i>
                            <input ng-model="user.password" name="password" type="password" placeholder="Password">
                        </div>

                    </div>
                    <div class="ui grid">
                        <div class="row two column">
                            <div class="column">
                                <button type="submit" class="fluid ui primary button">User Login</button>
                            </div>
                            <div class="column">
                                <a href="#" class="fluid ui positive button">Register</a>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
            <div class="ui attached segment" ng-if="loginComplete">
                <div class="ui green message">
                    <b>ผู้ใช้งาน : </b> {{user.firstname}} {{user.lastname}}
                </div>

                <div class="ui vertical fluid menu">
                    <a class="item">
                        เลือกสิทธิ์การใช้งาน
                    </a>
                    <a class="item" ng-repeat="role in user.roles " href="/{{role.key}}">
                        {{role.name}}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('.ui.dropdown').dropdown();
</script>

<script type="text/javascript" src="/packages/flow.js/dist/flow.min.js"></script>
<script type="text/javascript" src="/packages/angular/angular.min.js"></script>
<script type="text/javascript" src="/packages/angular-semantic-ui/dist/angular-semantic-ui.min.js"></script>
<script type="text/javascript" src="/packages/angular-ui-router/release/angular-ui-router.min.js"></script>
<script type="text/javascript" src="/packages/ng-flow/dist/ng-flow.min.js"></script>


<script type="text/javascript" src="/app/admin/AuthService.js"></script>
<script type="text/javascript" src="/app/admin/loader.js"></script>

<script type="text/javascript">

    var app = angular.module("MainApp", ['Auth', 'AppConfig']);
    app.controller("LoginCtrl", function ($scope, AuthService) {
        $scope.user = {}
        $scope.message = null;
        $scope.loginComplete = false;
        $scope.login = function () {
            $scope.user.csrf_token = "<?php echo csrf_token();?>";
            AuthService.login($scope.user).success(function (response) {
                //window.location = "/admin";
                //console.log(response);
                $scope.message = null;
                $scope.loginComplete = true;
                $scope.user = response;
                console.log($scope.loginComplete);
            }).error(function (response) {
                //console.log(response);
                $scope.message = response;
            })
        }
    })
</script>
</body>
</html>