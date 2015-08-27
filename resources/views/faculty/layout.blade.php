@extends('dashboard_master')

@section('header')
    @yield('header')
@stop


@section('sidemenu')
    <div class="item">
        <div class="header">
            Faculty
        </div>
        <div class="menu">
            <a class=" <% Request::is('faculty/faculty') ? 'active' : '' %> item" href="/faculty">
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