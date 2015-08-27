@extends('admin.layout')


@section('content')
    <div ng-app="ApiKeyAdmin">
        <div ng-controller="loadCtrl" ng-class="{active:active}" class="ui inverted dimmer ">
            <div class="ui large text loader">
                Loading
            </div>
        </div>

        <ui-view></ui-view>
    </div>

@stop


@section('javascript')
    <script type="text/javascript" src="/app/admin/ApiKeyService.js"></script>
    <script type="text/javascript" src="/app/admin/apikey/app.js"></script>
@stop