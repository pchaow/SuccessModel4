<?php namespace App\Http\Controllers\Researcher;

use App\Http\Controllers\Controller;
use \View;

class ResearcherController  extends Controller {

    public function __construct(){
        View::share('role_name','Researcher');
    }

	public function index()
	{
		return view('researcher.project.main');
	}



}
