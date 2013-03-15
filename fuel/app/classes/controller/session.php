<?php
class Controller_Session extends MyController 
{
	public function action_create()
	{
		//$this->not_logged_in();

		if (Input::method() == 'POST')
		{
			$users = Model_User::find()->where('email', Input::post('email'));
			$user = $users->get_one();

			if($user and ($user->password == crypt(Input::post('password'), $user->password)))
			{
				//echo $user->password."<br>";
				//echo crypt(Input::post('password'), $user->password)."<br>";
				//exit;

				Session::set_flash('success', 'Thank you, '.$user->name.' for logging in.');

				Session::set('user', $user);

				$location = ($user->type == 'admin') ? 'yachtshare' : 'seller';
				Response::redirect($location);				
			}else{
				Session::set_flash('error', 'The wrong email/password combination was entered.');
			}
		}

		$this->template = \View::forge('public_template',array(),false);
		$this->template->user = false;
		$this->template->title = 'Yacht Fractions';

		$data = array();
		if(isset($this->user))
			$data['user'] = $this->user;
		
		$this->template->offline = $this->offline;
		$this->template->content = View::forge('session/login', $data);
	}

	//Make sure this doesn't delete save forms
	public function action_logout()
	{
		$this->user = null;
		Session::delete('user');
		Session::set_flash('success', "You are now logged out.");
		Response::redirect('session/create');				
	}

	public function action_change_password($input=null)
	{
		//1. Parse the input parameters (GET)
		if(is_null($input))
			throw new HttpNotFoundException;

		$input_arr = explode("-", $input);
		$id = $input_arr[1];
		$created_at = $input_arr[0];

		$user = Model_User::find('first', array('where' => array('id' => $id, 'created_at' => $created_at)));

		if($user==null)
			throw new HttpNotFoundException;


		if(Input::method() == 'POST')
		{	
			$hashed_password = crypt(Input::post('new_password'));
			$user->password = $hashed_password;

			if($user->save())
			{	
				Session::set_flash("success", "Successfully changed your password to: ".Input::post('new_password'));
				Response::redirect("session/create");
			}else{
				Session::set_flash("error", "Error: could not change your password");
				Response::redirect("session/change_password/".$input);
			}
		}


		$this->template = \View::forge('public_template',array(),false);
		$this->template->user = $user;
		$this->template->title = 'Yacht Fractions: Change your Password';

		$this->template->offline = $this->offline;
		$this->template->content = View::forge('session/change_password', array('user' => $user, 'params' => $input));
	}

	public function action_forgot()
	{
		if (Input::method() == 'POST')
		{
			$user = Model_User::find('first', array('where' => array('email' => Input::post('email'))));

			if(!$user)
			{
				Session::set_flash('error', 'There is no user with the email: '.Input::post('email').' in our database!');
				Response::redirect('session/forgot');
			}else{
				//1. Create an instance
				$email = Email::forge();

				//2. The url at which teh user can change their password
				$url = Uri::create("session/change_password/".$user->created_at."-".$user->id);

				//3. Populate the email object
				$email->from($this->offline_config['from_email'], $this->offline_config['from_name']);
				$email->to($user->email);
				$email->subject('How to change your password');	
				$email->body("Hello, ".$user->name.", it seems as though you have forgetten your password? To change it to a new password please click the following link:<br>".$url);
/*
				echo "<pre>";
				print_r($email);
				echo "</pre>";
				exit;
*/
				//4. Send the email
				try
				{
					$email->send();
				}
				catch(\EmailValidationFailedException $e)
				{
					Session::set_flash('error', 'Details of how to change your password have been sent to your email address: '.$user->email);
					Response::redirect("session/forgot");
				}
				catch(\EmailSendingFailedException $e)
				{
					Session::set_flash('error', 'Your password cannot be recovered.');
					Response::redirect("session/forgot");							
				}

				Response::redirect("session/create");
			}
		}

		$this->template = \View::forge('public_template',array(),false);
		$this->template->user = false;
		$this->template->title = 'Yacht Fractions: Forgot Password';

		$this->template->offline = $this->offline;
		$this->template->content = View::forge('session/forgot');
	}

	public function action_save_form()
	{
		if (Input::method() == 'POST')
		{
			$form_input = Input::post('form');//Date::forge()->format("%H:%M:%S");
			$form_arr = array();
			foreach($form_input as $row_arr)
			{
				$form_arr[$row_arr['name']] = $row_arr['value'];
			}

			$type = Input::post('type');

			Session::delete($type.'_create_form');
			Session::set($type.'_create_form',$form_arr);
			//$this->save_form_session_to_db();
			//Session::delete($type.'_create_form');
			exit(Date::forge()->format("%Y-%m-%dT%H:%M:%SZ"));		//Return date in ISO 8601 format
		}
	}

	//Paramater $type can be either yachtshare or buyer
	protected function save_form_session_to_db()
	{
		$type = 'yachtshare';

		if(Session::get($type.'_create_form'))
		{
			$session_data = Session::get($type.'_create_form');

			$belongs_to = ($type == 'buyer') ? 'buyer' : 'seller';

			//1. Retreive the relevant formfields
			$formfields = Model_Formfieldbuyer::find('all', array('order_by' => array('order' => 'ASC'), 'where' => array('belongs_to' => $belongs_to)));

			//2. Insantiate model
			//IMPORTANT!!!! only works for saving yachtshares to DB so far (no buyer save)
			$yachtshare = Model_Yachtshare::forge();
			$boat_details = array();
			foreach($formfields as $field)
			{
				$tag = $field->tag;

				//If it is a mysql column
				if($field->search_field)
				{
					$yachtshare->$tag = $session_data[$tag];

				//Other wise push it to the json array
				}else{
					$boat_details[] = $session_data[$tag];
				}
			}

			$yachtshare->boat_details = json_encode($boat_details);
			$yachtshare->temp = true;

			if($yachtshare->save())
			{
				echo Date::forge()->format("%H:%M:%S");
			}else{
				echo "Error: form data could not be saved!";
			}
		}
	}

	protected function random_string() {
		$length = 10;
		$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
		$string = "";
		for ($p = 0; $p < $length; $p++) {
		    $string .= $characters[mt_rand(0, strlen($characters))];
		}
		return $string;
	}
}
