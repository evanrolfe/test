<?php
class Controller_Session extends MyController 
{
	public function action_create()
	{
		$this->not_logged_in();

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
		$this->template->title = 'Yacht Fractions: Login';

		$this->template->offline = $this->offline;
		$this->template->content = View::forge('session/login');
	}

	//Make sure this doesn't delete save forms
	public function action_logout()
	{
		$this->user = null;
		Session::delete('user');
		Session::set_flash('success', "You are not logged out.");
		Response::redirect('session/create');				
	}

	public function action_forgot()
	{
		if (Input::method() == 'POST')
		{
			$users = Model_User::find()->where('email', Input::post('email'));
			$user = $users->get_one();

			$new_password = $this->random_string();
			$hashed_password = crypt($new_password);

			$user->password = $hashed_password;

			if($user->save()) 
			{
				// Create an instance
				$email = Email::forge();

				$email->from($this->offline_config['from_email'], $this->offline_config['from_name']);
				$email->to($user->email);
				$email->subject('Password Reset');	
				$email->body("Your password has been reset to: ".$new_password);

				try
				{
					$email->send();
				}
				catch(\EmailValidationFailedException $e)
				{
					Session::set_flash('error', 'Your email has not been sent.');				
				}
				catch(\EmailSendingFailedException $e)
				{
					Session::set_flash('error', 'Your email has not been sent.');								
				}

				Session::set_flash('success', "Your new password has been sent to the email: ".$user->email."<br>Please make sure to check your JUNK MAIL if you do not receive an email within the next hour.");

				Response::redirect('session/create');				
			}else{
				Session::set_flash('error', 'Your password could not be reset due to an error!');
				Response::redirect('session/create');
			}
		}
        return new Response(View::forge('session/forgot'));
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

			$type = $form_arr['form_type'];

			Session::delete($type.'_create_form');
			Session::set($type.'_create_form',$form_arr);
			//$this->save_form_session_to_db();
			//Session::delete($type.'_create_form');
				echo "Last saved at ".(Date::forge()->format("%H:%M:%S"));
			exit;
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
				echo "Last saved at ".(Date::forge()->format("%H:%M:%S"));
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
