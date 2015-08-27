@extends('dashboard_master')

@section('header')
    @yield('header')
@stop


@section('sidemenu')
    <div class="item">
        <div class="header">
            Researcher
        </div>
        <div class="menu">
            <a class=" <% Request::is('resercher/resercher') ? 'active' : '' %> item" href="/researcher">
                <i class="home icon"></i>
                Home
            </a>
        </div>
    </div>

@stop

@section('content')
    @yield('content')
@stop


@section('javascript')
    @yield('javascript')
@stop