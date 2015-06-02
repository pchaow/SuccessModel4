<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminController extends Controller {

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

    public function project(){
        return view('admin.project.main');
    }

    public function projectStatus(){
        return view('admin.projectStatus.main');
    }
}
