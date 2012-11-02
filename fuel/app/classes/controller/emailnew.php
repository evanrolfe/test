<?php
class Controller_Emailnew extends MyController 
{
	protected static $bcc_email = "yachtfractions@gmail.com";//"chris31519@gmail.com";

	public function before()
	{
		parent::before();
		$this->logged_in_as(array('admin'));
	}

	public function action_create()
	{
		if(Input::method() == 'POST')
		{
			$post = Input::post();

			//1. Create an instance
			$email = Email::forge();

			//2. Populate email data
			$email->from('yachtfractions@evanrolfe.info', 'Yacht Fractions');
			$email->to(array(Input::post('to'), "yachtfractions@gmail.com"));
			$email->subject(Input::post('subject'));	
			$email->body(Input::post('body'));

			//3. If the yachtshare_id is defined then check attachments
			if(Input::post('yachtshare_id'))
			{
				$yachtshare = Model_Yachtshare::find((int)Input::post('yachtshare_id'));
				$available_files = Model_Image::find('all',array('where' => array('belongs_to' => 'yachtshare', 'public_image' => 1, 'belongs_to_id' => $yachtshare->id)));
				$attachments = array();
				foreach($available_files as $file)
				{
					if(Input::post('file_'.$file->id))
						$email->attach(DOCROOT.'uploads/'.$file->url);
				}
			}

			//4. Send the Email
			try
			{
				$email->send();

				//4.2 If this is a chaseup email then remove the "send email" link from hold side bar
				if(Input::post('template_id') == 2 && isset($yachtshare))
				{
					$hold_actionstep = $yachtshare->get_hold_actionstep();
					DB::query("UPDATE `actionsteps` SET email_sent=1 WHERE id=".$hold_actionstep['id'])->execute();
				}
			}
			catch(\EmailValidationFailedException $e)
			{
				Session::set_flash('error', 'Your email has not been sent.<br>'.$e);				
			}
			catch(\EmailSendingFailedException $e)
			{
				Session::set_flash('error', 'Your email has not been sent.<br>'.$e);								
			}

			//5. Redirect to appropriate destination
			if(Input::post('from_page') == 'yachtshare')
			{
				$url = 'yachtshare/view/'.$yachtshare->id;
			}elseif(Input::post('from_page') == 'buyer')
			{
				$url = 'buyer/view/'.Input::post('buyer_id');
			}elseif(Input::post('from_page') == 'hold')
			{
				$url = 'yachtshare'				;
			}
			Session::set_flash('success', 'Your email has been sent.');
			Response::redirect($url);
		}

		$data = array();

		//1. Get data from the GET input
		$data['from_page'] = $this->param('from_page');
		$data['template'] = Model_Emailtemplate::find($this->param('template_id'));

		($this->param('buyer_id') == 0) or $data['buyer'] = Model_Buyer::find($this->param('buyer_id'));
		($this->param('yachtshare_id') == 0) or $data['yachtshare'] = Model_Yachtshare::find($this->param('yachtshare_id'));

		//2. Parse Email Data
		$data['to'] = $data['buyer']->email;

		//2.1 Replace tags
		if(isset($data['buyer']) && isset($data['yachtshare']))
		{
			$data['subject'] = $this->replace_all_tags($data['template']->subject,$data['buyer'],$data['yachtshare']);
			$data['body'] = $this->replace_all_tags($data['template']->body,$data['buyer'],$data['yachtshare']);		
		}elseif(isset($data['buyer']))
		{
			$data['subject'] = $this->replace_buyer_tags($data['template']->subject,$data['buyer']);
			$data['body'] = $this->replace_buyer_tags($data['template']->body,$data['buyer']);						
		}elseif(isset($data['yachtshare']))
		{
			
		}

		//3. Attachments ONLY if this is with INTRODUCTION template
		$data['attachments'] = array();
		if($data['template']->id == 1)
		{
			$data['attachments'] = Model_Image::find('all',array('where' => array('belongs_to' => 'yachtshare', 'public_image' => 1, 'belongs_to_id' => $data['yachtshare']->id)));
			$data['attachments_json'] = json_encode($data['attachments']);
		}

		$this->template->title = "New Email";
		$this->template->content = View::forge('emailnew/create',$data);
	}

	public function action_mobile()
	{
		if(Input::method() == 'POST')
		{
			//1. Get Data into a string $content using the view 'data/mobile'
			$data = array();
			$data['buyers'] = Model_Buyer::find('all');
			$data['yachtshares'] = Model_Yachtshare::find('all');
			$content_sellers = View::forge('data/mobile_sellers', $data);			
			$content_buyers = View::forge('data/mobile_buyers', $data);			

			//2. Populate email data
			$email = Email::forge();
			$email->from('yachtfractions@evanrolfe.info', 'Yacht Fractions');
			$email->to("yachtfractions@gmail.com");
			$email->subject("Yachtfractions Data");	
			$email->body("");

			//3. Attach the data string
			$email->string_attach($content_sellers, "yachtfractions_data.htm");
			$email->string_attach($content_buyers, "yachtfractions_data.htm");

			//4. Send email
			try
			{
				$email->send();
				Session::set_flash('message', 'Your email has been sent.');
			}
			catch(\EmailValidationFailedException $e)
			{
				Session::set_flash('error', 'Your email has not been sent.<br>'.$e);				
			}
			catch(\EmailSendingFailedException $e)
			{
				Session::set_flash('error', 'Your email has not been sent.<br>'.$e);								
			}

			Response::redirect('mobile');
		}

		$this->template->title = "Export to Mobile";
		$this->template->content = View::forge('data/mobile_page');
	}

	public function action_test()
	{
		$buyer = Model_Buyer::find(67);
		$text = $this->replace_buyer_tags("hello {buyer_name} you have requested a boat with min {buyer_min_budget}",$buyer);


		$yachtshare = Model_YachtShare::find(1);
		$text = $this->replace_yachtshare_tags("Name: {yachtshare_name} Price:  {yachtshare_price}<br>Lying: {yachtshare_lying}",$yachtshare);
		die($text);
	}

	public static function replace_all_tags($str,$buyer,$yachtshare)
	{
		$str = self::replace_buyer_tags($str,$buyer);
		$str = self::replace_yachtshare_tags($str,$yachtshare);
		$str = self::replace_hold_tags($str,$buyer,$yachtshare);
		return $str;
	}

	public static function replace_hold_tags($str,$buyer,$yachtshare)
	{
			$hold = $yachtshare->get_hold_actionstep();
			
			$search = "/{hold_expires_at}/";
			$replace = Date::forge($hold['expires_at'])->format("%d/%m/%Y %H:%M");

			return preg_replace($search,$replace,$str);
	}

	public static function replace_buyer_tags($str,$buyer)
	{
		$fields = Model_Formfieldbuyer::find('all', array('where' => array('belongs_to' => 'buyer')));
		$search = array();
		$replace = array();

		foreach($fields as $field)
		{
			$tag = $field->tag;
			$search[] = "/{buyer_".$field->tag."}/";

			if(isset($buyer->preferences[$field->tag]))
			{
				$replace[] = $buyer->preferences[$field->tag];
			}elseif(isset($buyer->$tag))
			{
				$replace[] = $buyer->$tag;
			}else{
				$replace[] = "";
			}

			//Override share_size field to display a fraction instead of float
			if($field->tag == 'max_share_size' || $field->tag == 'min_share_size')
			{
				array_pop($replace);
				$replace[] = $buyer->preferences[$field->tag.'_fraction'];
			}

			//Override 'boats_interest' element to display the boat's names instead of just their ID's
			if($field->tag == 'boats_interest')
			{
        $boats_ids = explode(",",$buyer->preferences['boats_interest']);
        foreach($boats_ids as $id)
        {
          $yachtshare = Model_Yachtshare::find($id);
          $string .= $yachtshare->make.' - "'.$yachtshare->name.'", ';
        }

				  array_pop($replace);
          $replace[] = $string;
			}
		}

		return preg_replace($search,$replace,$str);
	}

	public static function replace_yachtshare_tags($str,$yachtshare)
	{
		$fields = Model_Formfieldbuyer::find('all', array('where' => array('belongs_to' => 'seller')));
		$search = array();
		$replace = array();

		foreach($fields as $field)
		{
			$tag = $field->tag;
			$search[] = "/{yachtshare_".$field->tag."}/";

			if(isset($yachtshare->boat_details[$field->tag]))
			{
				$replace[] = $yachtshare->boat_details[$field->tag];
			}elseif(isset($yachtshare->$tag))
			{
				$replace[] = $yachtshare->$tag;
			}else{
				$replace[] = "";
			}

			//Override share_size field to display a fraction instead of float
			if($field->tag == 'share_size')
			{
				array_pop($replace);
				$replace[] = $yachtshare->share_size_num.'/'.$yachtshare->share_size_den;
			}

		}

		return preg_replace($search,$replace,$str);
	}
}
