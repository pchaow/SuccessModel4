<?php namespace App\Http\Controllers\University;

use App\Http\Controllers\Controller;
use \View;



class UniversityController  extends Controller {

    public function __construct()
    {
        View::share('role_name', 'University');
    }

	public function index()
	{
		return view('university.project.main');
	}



}
