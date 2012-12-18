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
					$this->template = \View::forge('public_template',array(),false);
					$this->template->user = $this->user;
					$this->template->title = 'Yacht Fractions: Seller Registration';
					$this->template->content = View::forge('seller/search_results',$data);
					return new Response($this->template);

				}else{
					Session::set_flash('success', 'There were no yachtshares with the name '.Input::post('boat_name').' found in our database, please start the form from scratch:');
					Response::redirect('yachtshare/create');
				}	
			}else{
				Session::set_flash('error', 'You were not registered due to an error!');
				(count($result) > 0) and Session::set_flash('error', 'There is already another seller signed up with the same email!');
			}
		}

		$this->template = \View::forge('public_template',array(),false);
		//$this->template->user = $this->user;
		$this->template->title = 'Yacht Fractions: Seller Enquiry';
		$this->template->content = View::forge('seller/create');
	}

	public function action_index()
	{
		$this->logged_in_as(array('seller'));

		$data = array();
		$data['yachtshares'] = Model_Yachtshare::find('all', array("where" => array("user_id" => $this->user->id, 'temp' => 0)));
		$data['yachtshares_saved_for_later'] = Model_Yachtshare::find('all', array("where" => array("user_id" => $this->user->id, 'temp' => '1')));
		$data['user'] = $this->user;

		$this->template = \View::forge('public_template',array(),false);
		$this->template->user = $this->user;
		$this->template->title = 'Yacht Fractions: Seller Panel';
		$this->template->content = View::forge('seller/index',$data,false);
	}

	public function action_search()
	{
		$this->logged_in_as(array('seller'));
		$data['yachtshares'] = Model_Yachtshare::find('all',array('where' => array('temp' => 0)));

		if(Input::method() == 'POST')
		{
			$matches = array();
			foreach($data['yachtshares'] as $yachtshare){
				if(preg_match("/".Input::post('boat_name')."/i", $yachtshare->name))
					$matches[] = $yachtshare;
			}

			$data['yachtshares'] = $matches;

			$this->template = \View::forge('public_template',array(),false);
			$this->template->user = $this->user;
			$this->template->title = 'Yacht Fractions: Seller Panel';
			$this->template->content = View::forge('seller/search_results',$data,false);	
		}else{
			$this->template = \View::forge('public_template',array(),false);
			$this->template->user = $this->user;
			$this->template->title = 'Yacht Fractions: Seller Panel';
			$this->template->content = View::forge('seller/find_by_name',$data,false);	
		}
	}
}
