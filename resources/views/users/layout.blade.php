@extends('dashboard_users')

@section('header')
    @yield('header')
@stop


@section('sidemenu')
    <div class="item">
        <div class="header">
            User
        </div>
        <div class="menu">
            <a class=" <% Request::is('users/users') ? 'active' : '' %> item" href="/users">
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