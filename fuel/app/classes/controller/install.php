<?php
class Controller_Install extends MyController
{
	public function action_admin()
	{
		if(Input::method() == 'POST')
		{
			$hashed_password = crypt(Input::post('password'));

			$user = Model_User::forge(array(
				"email" 	=> Input::post('email'),
				"name"		=> Input::post('name'),
				"type"		=> "admin",
				"password" 	=> $hashed_password,
			));

			if($user and $user->save())
			{

				exit("The admin user has been succesfully created. The details are below. <font color='red'>Please make sure to delete the file ".APPPATH."classes/controller/install.php</font><hr>Email: ".Input::post('email')."<br>Password: ".Input::post('password'));

			}else{
				Session::set_flash('error', 'You were not registered due to an error!');
				Response::redirect('install/admin');
			}

		}else{
			return new Response(View::forge('install'));
		}
	}
}
