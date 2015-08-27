<?php namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use \View;


class UserController  extends Controller {

    public function __construct()
    {
        View::share('role_name', 'User');
    }

	public function index()
	{
		return view('users.project.main');
	}



}
