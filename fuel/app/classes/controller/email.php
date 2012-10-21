<?php
//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//NOT IN USE ANYMORE!!! 17/09/2012
//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
class Controller_Email extends MyController 
{

//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//NOT IN USE ANYMORE!!! 17/09/2012
//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	public function before()
	{
		parent::before();
		$this->logged_in_as(array('admin'));
	}

//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
//NOT IN USE ANYMORE!!! 17/09/2012
//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
	public function action_mobile()
	{
		$data = array();
		$data['buyers'] = Model_Buyer::find('all');
		$data['yachtshares'] = Model_Yachtshare::find('all');
		return new Response(View::forge('data/mobile', $data));
	}

	public function action_create()
	{
		if(Input::method() == 'POST')
		{
			// Create an instance
			$email = Email::forge();

			$email->from('yachtfractions@evanrolf.com', 'Yacht Fractions');
			$email->to(array(Input::post('to'), 'c.rolfe@ais'));
			$email->subject(Input::post('subject'));	
			$email->body(Input::post('body'));

			//Now update the email to say it has been sent
			$yachtshare = Model_Yachtshare::find(Input::post('yachtshare_id'));
			$available_files = Model_Image::find('all',array('where' => array('belongs_to' => 'yachtshare', 'public_image' => 1, 'belongs_to_id' => $yachtshare->id)));

			$attachments = array();
			foreach($available_files as $file)
			{
				if(Input::post('file_'.$file->id))
					$email->attach(DOCROOT.'uploads/'.$file->url);
			}

			//If this is a chaseup email then remove the "send email" link from hold side bar
			if(Input::post('template_id') == 2)
			{
				$hold_actionstep = $yachtshare->get_hold_actionstep();
				DB::query("UPDATE `actionsteps` SET email_sent=1 WHERE id=".$hold_actionstep['id'])->execute();
			}

			try
			{
				$email->send();
				Session::set_flash('message', 'Your email has been sent.');
			}
			catch(\EmailValidationFailedException $e)
			{
				Session::set_flash('error', 'Your email has not been sent.');				
			}
			catch(\EmailSendingFailedException $e)
			{
				Session::set_flash('error', 'Your email has not been sent.');								
			}

			if(Input::post('from_page') == 'yachtshare')
			{
				$url = 'yachtshare/view/'.$yachtshare->id;
			}elseif(Input::post('from_page') == 'yachtshare')
			{
				$url = 'buyer/view/'.Input::post('buyer_id');
			}elseif(Input::post('from_page') == 'hold')
			{
				$url = 'yachtshare'				;
			}

			Response::redirect($url);
		}

		$data = array();

		$template = Model_Emailtemplate::find($this->param('template_id'));
		($this->param('yachtshare_id') != 0) and $yachtshare = Model_Yachtshare::find($this->param('yachtshare_id'));
		($this->param('buyer_id') != 0) and $buyer = Model_Buyer::find($this->param('buyer_id'));		
		$parse_data = $this->tags($yachtshare, $buyer);

		(isset($buyer)) and $data['buyer'] = $buyer;
		(isset($yachtshare)) and $data['yachtshare'] = $yachtshare;
		(isset($yachtshare)) and $data['attachments'] = Model_Image::find('all',array('where' => array('belongs_to' => 'yachtshare', 'public_image' => 1, 'belongs_to_id' => $yachtshare->id)));
		(isset($data['attachments'])) and $data['attachments_json'] = json_encode($data['attachments']);
		$tags = array_keys($parse_data);
		$replace = array_values($parse_data);

		$data['template_id'] = $template->id;
		$data['to'] = $buyer->email;
		$data['subject'] = preg_replace($tags, $replace, $template->subject);
		$data['body'] = preg_replace($tags, $replace, $template->body);
		$data['from_page'] = $this->param('from_page');

		$this->template->title = "Send Email";
		$this->template->content = View::forge('email/create', $data);		
	}

	public function replace_tags($email,$yachtshare,$buyer)
	{
		$parse_data = Controller_Email::tags($yachtshare, $buyer);
		$tags = array_keys($parse_data);
		$replace = array_values($parse_data);

		$email->subject = preg_replace($tags, $replace, $email->subject);
		$email->body = preg_replace($tags, $replace, $email->body);

		return $email;
	}

	public function action_tags()
	{
		$yachtshare = Model_Yachtshare::find(1);
		$buyer = Model_Buyer::find(38);
		$search_replace = $this->tags($yachtshare, $buyer);

		echo "<pre>";
		print_r($search_replace);
		echo "</pre>";
		exit;
	}

	public static function replace_buyer_tags($str, $buyer)
	{
		$fields = Model_Formfieldbuyer::find('all', array('where' => array('belongs_to' => 'buyer')));

		foreach($fields as $field)
		{
			$tag = $field->tag;

			//If the field is contained in buyer->preferences
			if(isset($buyer->preferences[$tag]))
			{
				$search_replace['{buyer_'.$field->tag.'}'] = $buyer->preferences[$tag];		
			}elseif(isset($buyer->$tag))
			{
				$search_replace['{buyer_'.$field->tag.'}'] = $buyer->$tag;							
			}			
		}

		return $search_replace;
	}

	public static function tags($yachtshare = null, $buyer = null, $expires_at = null)
	{
		$fields = Model_Formfieldbuyer::find('all');

		$search_replace = array();

		foreach($fields as $field)
		{
			$tag = $field->tag;
			if($field->belongs_to == 'seller' and $yachtshare)
			{
				if(isset($yachtshare->boat_details[$tag]) && !isset($yachtshare->$tag))
				{
					$search_replace['{yachtshare_'.$field->tag.'}'] = $yachtshare->boat_details[$tag];		
				}elseif(!isset($yachtshare->boat_details[$tag]) && isset($yachtshare->$tag))
				{
					$search_replace['{yachtshare_'.$field->tag.'}'] = $yachtshare->$tag;							
				}else{
					$search_replace['{yachtshare_'.$field->tag.'}'] = '';												
				}
			
			}elseif($field->belongs_to == 'buyer' and $buyer){

				if(isset($buyer->preferences[$tag]) && !isset($buyer->$tag))
				{
					$search_replace['{buyer_'.$field->tag.'}'] = $buyer->preferences[$tag];		
				}elseif(!isset($buyer->preferences[$tag]) && isset($buyer->$tag))
				{
					$search_replace['{buyer_'.$field->tag.'}'] = $buyer->$tag;							
				}else{
					$search_replace['{buyer_'.$field->tag.'}'] = '';												
				}


			}else{
				$belongs_to = ($field->belongs_to == 'buyer') ? 'buyer' : 'yachtshare';
				$search_replace[] = '{'.$belongs_to.'_'.$field->tag.'}';
			}
		}

		if($buyer and $yachtshare)
		{
			$hold = $yachtshare->get_hold_actionstep();
			$search_replace['{hold_expires_at}'] = Date::forge($hold['expires_at'])->format("%d/%m/%Y %H:%M");						
		}else{
			$search_replace[] = '{hold_expires_at}'; //Date::forge()->format("%d/%m/%Y %H:%M");			
		}


		foreach($search_replace as $key => $value)
		{
			$search_replace["/".$key."/"] = $value;
			unset($search_replace[$key]);
		}

		return $search_replace;
	}
}
