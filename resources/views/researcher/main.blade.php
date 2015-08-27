@extends('researcher.layout')
@section('header')
    <link rel="stylesheet" href="/packages/angular-chart.js/dist/angular-chart.css">
@stop
@section('content')
    <h2>Dashboard</h2>

    <div ng-app="DashboardApp" class="">
        <div class="ui two column grid">
            <div class="two column">
                <div class="ui top attached purple inverted segment">
                    แผนภูมิแสดงจำนวนโครงการต่อคณะ
                </div>
                <div class="ui attached segment">
                <div ng-controller="ProjectFacultyChartCtrl">
                    <canvas id="bar" style="height: 400px;" class="chart chart-pie" data="data" labels="labels" legend="true">></canvas>
                </div>
                </div>
            </div>

        </div>

    </div>
@stop


@section('javascript')
    <script type="text/javascript" src="/packages/chart.js/Chart.min.js"></script>
    <script type="text/javascript" src="/packages/angular-chart.js/dist/angular-chart.min.js"></script>

    <script type="text/javascript" src="/app/admin/ChartService.js"></script>
    <script type="text/javascript">
        var app = angular.module("DashboardApp",['chart.js',"SuccessChart"]);
        app.controller("ProjectFacultyChartCtrl",function($scope,ChartService){
            ChartService.facultyProjectChart().success(function(response){
                $scope.labels = response.labels;
                $scope.data = response.data[0];
                $scope.series = response.series;
            })
        })
    </script>
@stop
