<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use \View;
class AdminController extends Controller
{

    public function __construct()
    {
        View::share('role_name', 'Administrator');
    }

    public function index()
    {
        return redirect('/admin/dashboard');
    }

    public function dashboard()
    {
        return view('admin.main');
    }

    public function role()
    {
        return view('admin.role.main');
    }

    public function project()
    {
        return view('admin.project.main');
    }

    public function projectStatus()
    {
        return view('admin.projectStatus.main');
    }

    public function faculty()
    {
        return view('admin.faculty.main');
    }

    public function user()
    {
        return view('admin.user.main');
    }

    public function apikey()
    {
        return view('admin.apikey.main');
    }
    public function area()
    {
        return view('admin.area.main');
    }
}
