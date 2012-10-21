<?php
class Controller_Seller extends MyController
{
	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$hashed_password = crypt(Input::post('password'));

			$user = Model_User::forge(array(
				"email" 	=> Input::post('email'),
				"name"		=> Input::post('name'),
				"type"		=> "seller",
				"password" 	=> $hashed_password,
			));

			$result = DB::query('SELECT * FROM `users` WHERE email="'.Input::post('email').'"')->execute();

			if(count($result) == 0 and $user and $user->save())
			{
				$data['yachtshares'] = Model_Yachtshare::find('all');
				$matches = array();
				foreach($data['yachtshares'] as $yachtshare){
					if(preg_match("/".Input::post('boat_name')."/i", $yachtshare->name))
						$matches[] = $yachtshare;
				}

				Session::set('user', $user);

				$data['yachtshares'] = $matches;

				if(count($matches)>0)
				{
		 	   		return new Response(View::forge('seller/search_results', $data));
				}else{
					Response::redirect('yachtshare/create');
				}	
			}else{
				Session::set_flash('error', 'You were not registered due to an error!');
				(count($result) > 0) and Session::set_flash('error', 'There is already another seller signed up with the same email!');
			}
		}

        return new Response(View::forge('seller/create'));
	}

	public function action_index()
	{
		$this->logged_in_as(array('seller'));

		$data = array();
		$data['yachtshares'] = Model_Yachtshare::find('all', array("where" => array("user_id" => $this->user->id)));
		$data['user'] = $this->user;

        return new Response(View::forge('seller/index',$data));	
	}

	public function action_search()
	{
		$this->logged_in_as(array('seller'));
		$data['yachtshares'] = Model_Yachtshare::find('all');

		if(Input::method() == 'POST')
		{
			$matches = array();
			foreach($data['yachtshares'] as $yachtshare){
				if(preg_match("/".Input::post('boat_name')."/i", $yachtshare->name))
					$matches[] = $yachtshare;
			}

			$data['yachtshares'] = $matches;

     	   return new Response(View::forge('seller/search_results', $data));	
		}else{
    	    return new Response(View::forge('seller/find_by_name', $data));	
		}


	}
}
