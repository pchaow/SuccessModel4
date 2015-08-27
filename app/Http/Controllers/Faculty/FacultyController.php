<?php namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use \View;


class FacultyController  extends Controller {

    public function __construct()
    {
        View::share('role_name', 'Faculty');
    }

	public function index()
	{
		return view('faculty.project.main');
	}



}
