@extends('dashboard_master')

@section('header')
    @yield('header')
@stop

@section('sidemenu')
    <div class="item">
        <div class="header">
            Administrator
        </div>
        <div class="menu">
            <a class=" <% Request::is('admin/dashboard') ? 'active' : '' %> item" href="/admin">
                <i class="home icon"></i>
                Dashboard
            </a>
        </div>
        <div class="menu">
            <a class=" <% Request::is('admin/area') ? 'active' : '' %> item" href="/admin/area">
                Area
            </a>
        </div>
    </div>


    <div class="item">
        <div class="header">
            Faculty Management
        </div>
        <div class="menu">
            <a class=" <% Request::is('admin/faculty') ? 'active' : '' %> item" href="/admin/faculty">
                Faculty
            </a>

        </div>
    </div>

    <div class="item">
        <div class="header">
            Success Model Management
        </div>
        <div class="menu">
            <a class=" <% Request::is('admin/project') ? 'active' : '' %> item" href="/admin/project">
                Projects
            </a>

            <a class=" <% Request::is('admin/project-status') ? 'active' : '' %> item" href="/admin/project-status">
                Project Status
            </a>
        </div>
    </div>

    <div class="item">
        <div class="header">
            User Management
        </div>
        <div class="menu">
            <a class=" <% Request::is('admin/user') ? 'active' : '' %> item" href="/admin/user">
                Users
            </a>
            <a class=" <% Request::is('admin/role') ? 'active' : '' %> item" href="/admin/role">
                Roles
            </a>
        </div>
    </div>

    <div class="item">
        <div class="header">
            Security Management
        </div>
        <div class="menu">
            <a class=" <% Request::is('admin/api-key') ? 'active' : '' %> item" href="/admin/api-key">
                Api Key
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