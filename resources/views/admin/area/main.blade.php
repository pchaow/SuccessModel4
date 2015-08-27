@extends('admin.layout')


@section('content')
    <div ng-app="AreaAdmin">
        <div ng-controller="loadCtrl" ng-class="{active:active}" class="ui inverted dimmer ">
            <div class="ui large text loader">
                Loading
            </div>
        </div>

        <ui-view></ui-view>
    </div>

@stop


@section('javascript')
    <script type="text/javascript" src="/app/admin/UserService.js"></script>
    <script type="text/javascript" src="/app/admin/FacultyService.js"></script>
    <script type="text/javascript" src="/app/admin/AreaService.js"></script>
    <script type="text/javascript" src="/app/admin/area/app.js"></script>
@stop