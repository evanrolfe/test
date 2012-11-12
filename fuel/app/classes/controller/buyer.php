<?php
class Controller_Buyer extends MyController 
{
	public function before(){
		parent::before();

		$this->template->links['buyers']['current'] = true;

		$this->fields_search = Model_Formfieldbuyer::find('all', array('order_by' => array('order' => 'ASC'), 'where' => array('belongs_to' => 'buyer')));

	}

	public function action_index()
	{
		$this->logged_in_as(array('admin'));
		$this->template->title = "Buyer: List";
		$this->render_list('buyer');
	}

	//View Yachtshare => Find Buyers for this yachtshare
	public function action_find_for_yachtshare()
	{
		$this->logged_in_as(array('admin'));
		$id = $this->param('yachtshare_id');
		$data['yachtshare'] = Model_Yachtshare::find($id);
		$data['from_page'] = 'yachtshare';
		$this->template->title = "Yachtshare: ".$data['yachtshare']->name;
		$this->template->links['buyers']['current'] = false;
		$this->template->links['shares']['current'] = true;

		$search_terms = array(
				'type' 				=> $data['yachtshare']->type,
				'location_general' 	=> $data['yachtshare']->location_general,
				'location_specific' => $data['yachtshare']->location_specific,
				'price' 			=> $data['yachtshare']->price,
				'length' 			=> $data['yachtshare']->length,
				'share_size' 		=> $data['yachtshare']->share_size,
				'share_size_num' 	=> $data['yachtshare']->share_size_num,
				'share_size_den' 	=> $data['yachtshare']->share_size_den,
		);

		$this->render_list('yachtshare/find_buyers/'.$id,$data,$search_terms);
	}

	protected function render_list($current_page, $data=array(),$search_terms = array())
	{
		$data['current_page'] = $current_page;
		$data['type'] =  Model_Formfieldbuyer::find('first', array('where' => array('tag'=>'type','belongs_to'=>'seller')));
		$data['location_general'] =  Model_Formfieldbuyer::find('first', array('where' => array('tag'=>'location_general','belongs_to'=>'seller')));
		$data['location_specific'] = Model_Formfieldbuyer::find('first', array('where' => array('tag'=>'location_specific','belongs_to'=>'seller')));

		$data['search_terms'] = array(
				'type' => '',
				'location_general' => '',
				'location_specific' => '',
				'max_budget' => '',
				'min_budget' => '',
				'max_loa' => '',
				'min_loa' => '',
				'max_share_size' => '',
				'min_share_size' => '',
		);

		$data['columns'] = (Session::get('columns_buyer')) ? Session::get('columns_buyer') : array('name', 'email', 'num_introductions', 'price_range', 'share_size_range', 'length_range');

		$data['column_labels'] = array('name' => 'Name', 'email' => 'Email', 'location_general' => 'Location (general)', 'location_specific' => 'Location (specific)', 'type' => 'Type', 'num_introductions' => '# Introductions', 'price_range' => 'Price range', 'share_size_range' => 'Share size range', 'length_range' => 'Length Range', 'sale_progress' => 'Sale Progress');

		$this->handle_post_buyers(Input::post(), $current_page,$search_terms);
		$data['search_terms'] = $this->data['search_terms'];
		$data['buyers'] = ($this->param('all')) ? Model_Buyer::find('all') : $this->data['buyers'];

		//$data['buyers'] = Model_Buyer::find('all');

		$this->template->content = View::forge('buyer/index', $data);		
	}


	public function action_view($id = null)
	{
		$this->logged_in_as(array('admin'));
		is_null($id) and Response::redirect('Buyer');

		$data['buyer'] = Model_Buyer::find($id);
		$this->template->title = "Buyer: ".$data['buyer']->name;

		//Sort the data into two categores: Buyer details and boat specification details
		$data['boat_specifications'] = array();
		$data['buyer_info'] = array();
		foreach($this->fields_search as $field)
		{
			if($field->search_field && !in_array($field->tag,array('email','name','boats_interest')))
			{
				$data['boat_specifications'][$field->label] = (isset($data['buyer']->preferences[$field->tag])) ? $data['buyer']->preferences[$field->tag] : '';
			}elseif(!in_array($field->tag,array('email','name'))){
				$data['buyer_info'][$field->label] = (isset($data['buyer']->preferences[$field->tag])) ? $data['buyer']->preferences[$field->tag] : '';
			}

			//Override the share sizes to display fractions instead of floats
			if($field->tag == 'max_share_size' || $field->tag == 'min_share_size')
			{
				$data['buyer_info'][$field->label] = $data['buyer']->preferences[$field->tag.'_fraction'];
				$data['boat_specifications'][$field->label] = $data['buyer']->preferences[$field->tag.'_fraction'];
			}

			//Override 'boats_interest' element to display the boat's names instead of just their ID's
			if($field->tag == 'boats_interest')
			{
        $boats_ids = explode(",",$data['buyer']->preferences['boats_interest']);
        foreach($boats_ids as $id)
        {
          $yachtshare = Model_Yachtshare::find($id);
          $string .= $yachtshare->make.' - "'.$yachtshare->name.'", ';
        }
				$data['buyer_info'][$field->label] = $string;
			}
		}
/*
		$spec_keys = array("Keel type:", "Mooring type:", "Do you need school holidays?", "Boat make/style preference?", "Number of years as skipper:", "Number of years total sailing:","Number of berths:","Number of cabins:","Minimum length LOA:","Maximum length LOA:","Share size: (eg quarter/third/half)","Budget minimum:","Budget maximum:","Preferred Location (General)","Preferred Location (Specific)","Typical number of days you expect to have on board per holiday:","Typical sailing range:");

		foreach($data['data'] as $key => $value)
		{
			if(in_array($key, $spec_keys))
			{
				unset($data['data'][$key]);
				$data['boat_specifications'][$key] = $value;
			}
		}
*/

		$this->template->content = View::forge('buyer/view', $data);
	}


	public function action_handle_post()
	{
		if (Input::method() == 'POST')
		{
			//1. Gather all search fields into one array
			$input = array();

			foreach($this->fields_search as $field)
			{
				//Skip the email and name fields since they have their own column in the mysql table
				if(in_array($field->tag, array('email', 'name')))
					continue;

				//Handle fraction input
				if($field->type == 'text_fraction')
				{
					$input[$field->tag] = $this->toFloat(Input::post($field->tag."_num")."/".Input::post($field->tag."_den"));
					$input[$field->tag."_num"] = Input::post($field->tag."_num");
					$input[$field->tag."_den"] = Input::post($field->tag."_den");

				//Handle length input (i.e. meters/feet)
				}elseif($field->type == 'length'){
					$input[$field->tag] = (Input::post($field->tag.'_unit') == 'm') ? Input::post($field->tag) : round(Input::post($field->tag)*0.3048,2);

				//Handle price input => remove commas
				}elseif($field->tag == 'min_budget' || $field->tag == 'max_budget'){
					$input[$field->tag] = $this->handle_price(Input::post($field->tag));



					

				//Or handle normal (direct) input
				}else{
					$input[$field->tag] = Input::post($field->tag);
				}
			}

			//Handle boats interested
			$input['boats_interest'] = Input::post('interest1').','.Input::post('interest2').','.Input::post('interest3');

			//2. Encode into json format
			$preferences = json_encode($input);	

			//Now either insert into DB or update DB entry
			if(Input::post('insert'))
			{
				//3. Insert into DB
				$buyer = Model_Buyer::forge(array(
					'name' => Input::post('name'),
					'email' => Input::post('email'),
					'preferences' => $preferences,
				));

				$all_buyers = Model_Buyer::find('all');
				foreach($all_buyers as $a_buyer)
				{
					if($buyer->email == $a_buyer->email)
					{
						Session::set_flash('error', 'Error: could not save the enquiry because the email, '.$buyer->email.' you have entered is already in use.');
						Response::redirect('buyer/create');						
					}
				}

				if ($buyer and $buyer->save())
				{

					//Delete the saved_form session
					Session::delete('buyer_create_form');

					$id = (int) $buyer->id;
					Response::redirect('buyer/thankyou/'.$id);

				}else{
					Session::set_flash('error', 'Could not save buyer.');
					Response::redirect('buyer/create');
				}

			//Or Update the DB
			}elseif(Input::post('update')){
			
				$buyer = Model_Buyer::find(Input::post('buyer_id'));

				$buyer->name = Input::post('name');
				$buyer->email = Input::post('email');
				$buyer->preferences = $preferences;

				if ($buyer and $buyer->save())
				{
					Session::set_flash('success', 'Updated buyer #'.$buyer->id.'.');
					Response::redirect('buyer/view/'.$buyer->id);
				}else{
					Session::set_flash('error', 'Could not save buyer.');
					Response::redirect('buyer/create');
				}
			}
		}
	}

	public function action_thankyou($id = null)
	{
		is_null($id) and Response::redirect('buyer/create');

		$data['buyer'] = Model_Buyer::find($id);

		//Send the automated email
		//1. Create an instance
		$email = Email::forge();
		$template = Model_Emailtemplate::find(3);

		//2. Populate email data
		$email->from($this->offline_config['from_email'], $this->offline_config['from_name']);
		$email->to(array($data['buyer']->email,$this->offline_config['admin_email']));
		$email->subject(Controller_Emailnew::replace_buyer_tags($template->subject,$data['buyer']));	
		$body = Controller_Emailnew::replace_buyer_tags($template->body,$data['buyer']);
		$email->body($body);

		//4. Sending the email
		try
		{
			$email->send();
		}
		catch(\EmailValidationFailedException $e)
		{
			//Session::set_flash('error', 'Your email has not been sent.<br>'.$e);				
		}
		catch(\EmailSendingFailedException $e)
		{
			//Session::set_flash('error', 'Your email has not been sent.<br>'.$e);								
		}

		//5. Format the search fields to include the Label as the array key
		$data['fields'] = array();
		foreach($this->fields_search as $field)
		{
			$data['fields'][$field->tag] = $field->label;
		}

		$this->template = \View::forge('public_template',array(),false);
		$this->template->user = $this->user;
		$this->template->content_width = $this->content_width;
		$this->template->title = 'Yacht Fractions: Buyer Enquiry';
		$this->template->content = View::forge('buyer/thankyou', $data,false);
	}

/*
* DEPRACATED!
*
* See action_handle_post() instead
*/
	public function action_create()
	{
		//$this->logged_in_as(array('admin'));

		if (Input::method() == 'POST')
		{
			//1. Gather all search fields into one array
			$input = array();
			echo "<pre>";
			print_r($input);
			echo "</pre>";
			exit;
			foreach($this->fields_search as $field)
			{
				//Skip the email and name fields since they have their own column in the mysql table
				if(in_array($field->tag, array('email', 'name','boats_interest')))
					continue;

				//Handle fraction input
				if($field->type == 'text_fraction')
				{
					$input[$field->tag] = $this->toFloat(Input::post($field->tag."_numerator")."/".Input::post($field->tag."_denomenator"));
					$input[$field->tag."_num"] = Input::post($field->tag."_numerator");
					$input[$field->tag."_den"] = Input::post($field->tag."_denomenator");

				//Handle length input (i.e. meters/feet)
				}elseif($field->type == 'length'){
					$input[$field->tag] = (Input::post($field->tag.'_unit') == 'm') ? Input::post($field->tag) : round(Input::post($field->tag)*0.3048,2);
				//Or handle normal (direct) input
				}else{
					$input[$field->tag] = Input::post($field->tag);
				}
			}

			//2. Handle boats_interest
			


			//3. Encode into json format
			$preferences = json_encode($input);

			//4. Insert into DB
			$buyer = Model_Buyer::forge(array(
				'name' => Input::post('name'),
				'email' => Input::post('email'),
				'preferences' => $preferences,
			));

			if ($buyer and $buyer->save())
			{
				Session::set_flash('success', 'Added buyer #'.$buyer->id.'.');

				Response::redirect('buyer');
			}else{
				Session::set_flash('error', 'Could not save buyer.');
			}

		}

		$data['yachtshares'] = Model_Yachtshare::find('all',array('order_by' => array('make' => 'ASC')));

		$shares_for_json = array();
		foreach($data['yachtshares'] as $share)
		{
			$shares_for_json[$share->id] = $share->name;
		}

		$data['saved_form_data'] = Session::get('buyer_create_form');
		$data['types'] = array("Sailing boat shares UK", "Sailing boat shares overseas", "Motor boat shares UK", "Used Yacht on brokerage", "Used yacht in Greece", "Used yacht - private sale");
		$data['json_shares'] = json_encode($shares_for_json);

        $data['title']   = "Buyer Enquiry Form";
        //$data['content'] = "Don't show me in the template";

		//For the new view (create2.php)
		$data['fields_search'] = $this->fields_search;

        // returned Response object takes precedence and will show content without template
		$this->template = \View::forge('public_template',array(),false);
		$this->template->user = $this->user;
		$this->template->content_width = $this->content_width;
		$this->template->title = 'Yacht Fractions: Buyer Enquiry';
		$this->template->form_page = true;												//To set the html body to display "are you sure" popup on exit
		$this->template->content = View::forge('buyer/create2', $data,false);
	}

	public function action_edit($id = null)
	{
		$this->logged_in_as(array('admin'));
		is_null($id) and Response::redirect('Buyer');
		$buyer = Model_Buyer::find($id);
		$data['formfields'] = $this->fields_search;

		$data['buyer'] = $buyer;

		$this->template->title = "Buyer: ".$data['buyer']->name;
		$this->template->content = View::forge('buyer/edit', $data,false);

	}

	public function action_delete($id = null)
	{
		$this->logged_in_as(array('admin'));
		if ($buyer = Model_Buyer::find($id))
		{
			$buyer->delete();

			Session::set_flash('success', 'Deleted buyer #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete buyer #'.$id);
		}

		Response::redirect('buyer');

	}
}
