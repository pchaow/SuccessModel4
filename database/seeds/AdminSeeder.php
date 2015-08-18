<?php
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Faculty;

class AdminSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */


	public function run()
	{

        $user = new \App\Models\User();
        $user->email="admin@success.local";
        $user->password =  \Hash::make("1234");
        $user->save();

        $role = \App\Models\Role::where("key","=","admin")->first();
        $user->roles()->attach($role->id);

    }

}
