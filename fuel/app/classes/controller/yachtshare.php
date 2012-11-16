<?php

class Controller_Yachtshare extends MyController
{
	public function before()
	{
		parent::before();
		$this->formfields = Model_Formfieldbuyer::find('all', array('order_by' => array('order' => 'ASC'), 'where' => array('belongs_to' => 'seller')));
	}

	public function action_index($all = null)
	{
		$this->logged_in_as(array('admin'));
		$this->template->links['shares']['current'] = true;
		$this->template->title = "Yachtshare: List";

		//Find the yachtshares according to any user defined filter preferences
		$this->render_list('yachtshare',array('show_new_button' => true, 'from_page' => 'yachtshare'));
	}

	public function action_set_reminder()
	{
		if(Input::method() == 'POST')
		{
			$post = Input::post();
			$id = Input::post('yachtshare_id');

			if(isset($post['update']))
			{
				$time = explode("/",Input::post('expires_at'));
				$expires_at= ((Input::post('expires_at')) != "") ? mktime(0,0,0,(int)$time[1],(int)$time[0],(int)$time[2]) : time();
				$reminder = addslashes(Input::post('reminder'));		
			}elseif(isset($post['delete']))
			{
				$expires_at = 0;
				$reminder = "";
			}

			$query = DB::query('UPDATE `yachtshares` SET reminder="'.$reminder.'",reminder_expires_at='.$expires_at.' WHERE id='.$id);

			if($query and $query->execute())
			{
				Session::set_flash('success', 'Your reminder has been set for: '.Input::post('expires_at').', to edit the reminder: scroll to the bottom of the page for the form.');
			}else{
				Session::set_flash('error', 'Your reminder could not be set due to an error.');				
			}

			Response::redirect('yachtshare/'.Input::post('from_page').'/'.$id);																				
		}
	}

	//Search yachtshares for a specific buyer_id
	public function action_find_for_buyer()
	{
		$id = $this->param('buyer_id');

		if(is_null($id))
			throw new HttpNotFoundException;

		$data['buyer'] = Model_Buyer::find($id);

		if(!$data['buyer'])
			throw new HttpNotFoundException;

		$data['from_page'] = 'buyer';

		$this->logged_in_as(array('admin'));
		$this->template->title = "Buyer: ".$data['buyer']->name;

		$this->template->links['buyers']['current'] = true;

		$search_terms = array(
			'type' 				=> $data['buyer']->preferences['type'],
			'location_general' 	=> $data['buyer']->preferences['location_general'],
			'location_specific' => $data['buyer']->preferences['location_specific'],
			'max_budget' 		=> $data['buyer']->preferences['max_budget'],
			'min_budget' 		=> $data['buyer']->preferences['min_budget'],
			'max_loa' 			=> $data['buyer']->preferences['max_loa'],
			'min_loa' 			=> $data['buyer']->preferences['min_loa'],

			'max_share_size' 	=> $data['buyer']->preferences['max_share_size'],
			'min_share_size' 	=> $data['buyer']->preferences['min_share_size'],
			'max_share_size_numerator' => $data['buyer']->preferences['max_share_size_num'],
			'max_share_size_denomenator' => $data['buyer']->preferences['max_share_size_den'],
			'min_share_size_numerator' => $data['buyer']->preferences['min_share_size_num'],
			'min_share_size_denomenator' =>	 $data['buyer']->preferences['min_share_size_den'],

			'available' => true,
			'on_hold' => true,
			'sale_in_progress' => true,
		);
		$str = $data['buyer']->preferences['boats_interest'];
		$data['yachtshares_interest'] = explode(",",$str);

		$this->render_list('buyer/find_yachtshares/'.$id, $data,$search_terms);
	}

	protected function render_list($current_page,$data=array(),$search_terms = array())
	{
		//Find the yachtshares according to any user defined filter preferences
		$this->handle_post_yachtshares(Input::post(), $current_page, $search_terms);
		$data['current_page'] = $current_page;
		$data['search_terms'] = $this->data['search_terms'];
		
		$data['yachtshares'] = ($this->param('all')) ? Model_Yachtshare::find('all') : $this->data['yachtshares'];
		$data['columns'] = (Session::get('columns')) ? Session::get('columns') : array('name', 'location_specific', 'length', 'price', 'share_size', 'sale_progress');

		$data['column_labels'] = array('name' => 'Name', 'make' => 'Make', 'type' => 'Type', 'location_specific' => 'Location Specific', 'location_general' => 'Location General', 'length' => 'Length (m)', 'price' => 'Price', 'share_size' => 'Share Size', 'sale_progress' => 'Sale Progress', 'status' => 'Status', 'introductions' => '# Introductions', 'last_activity' => 'Date of last activity');

		//Filter form fields OPTIONS for select dropdowns
		$data['type'] =  Model_Formfieldbuyer::find('first', array('where' => array('tag'=>'type','belongs_to'=>'seller')));
		$data['location_general'] =  Model_Formfieldbuyer::find('first', array('where' => array('tag'=>'location_general','belongs_to'=>'seller')));
		$data['location_specific'] = Model_Formfieldbuyer::find('first', array('where' => array('tag'=>'location_specific','belongs_to'=>'seller')));
		//$data['location_specific'] = $query->get_one();

		$this->template->content = View::forge('yachtshare/index',$data);
	}

	public function action_view($id = null)
	{
		$this->logged_in_as(array('admin', 'seller'));

		if(is_null($id))
			throw new HttpNotFoundException;

		$data['yachtshare'] = Model_Yachtshare::find($id);

		if(!$data['yachtshare'])
			throw new HttpNotFoundException;

		$this->template->title = "Yachtshare: ".$data['yachtshare']->name;
		$this->template->links['shares']['current'] = true;

		$data['formfields'] = Model_Formfieldbuyer::find('all', array('order_by' => array('order' => 'ASC'), 'where' => array('belongs_to' => 'seller')));

		//$similar_yachtshares = DB::query('SELECT * FROM `yachtshares` WHERE name LIKE "%'.$data['yachtshare']->name.'%"')->execute();
		$name_arr = explode(" ",$data['yachtshare']->name);
		$name = $name_arr[0];
		$data['similar'] = DB::query('SELECT * FROM `yachtshares` WHERE name LIKE "%'.$name.'%" AND name NOT IN ("'.$data['yachtshare']->name.'")')->as_object()->execute();

		if($this->user->type == 'admin') 
		{
			$this->template->content = View::forge('yachtshare/admin/view',$data,false);			
		}else{
		$this->template = \View::forge('public_template',array(),false);
		$this->template->user = $this->user;
		$this->template->title = 'Yacht Fractions: Viewing Yachtshare';
		$this->template->content = View::forge('yachtshare/seller/view',$data,false);
		}

	}

	public function action_handle_post()
	{
		if(Input::method() == 'POST')
		{
			$formfields = Model_Formfieldbuyer::find('all', array('order_by' => array('order' => 'ASC'), 'where' => array('belongs_to' => 'seller')));	
			$mysql_columns = array("name","make","type","location_general","location_specific","length","price","share_size","share_size_num","share_size_den");

			//1. Go through each formfield and extract the necessary data from POST input
			foreach($formfields as $field)
			{
				//Skip those which have their own mysql columns
				if(in_array($field->tag,$mysql_columns))
					continue;

				//Handle length input (i.e. meters/feet)
				if($field->type == 'length')
				{
					$input[$field->tag] = (Input::post($field->tag.'_unit') == 'm') ? Input::post($field->tag) : round(Input::post($field->tag)*0.3048,2);

				//Handle price input => remove commas
				}elseif($field->tag == 'price'){
					$input[$field->tag] = preg_replace(array('/,/','/\./'),"",Input::post($field->tag));

				//Or handle normal (direct) input
				}else{
					$input[$field->tag] = Input::post($field->tag);
				}
			}

			//2. Handle Share sizes if yachtshares are being INSERTED
			if(Input::post('insert'))
			{
				//2.1 Find out out many shares are to be inserted and what size each one is
				$shares = array();
				for($i=1; $i<=10; $i++)
				{
					if(Input::post("share_".$i."_num"))
					{
						$num = Input::post("share_".$i."_num");
						$den = Input::post("share_".$i."_den");
						$float = $this->toFloat($num."/".$den);

						$shares[] = array('num' => $num, 'den' => $den, 'float' => $float);
					}
				}				

				//Check that the user has inputted a sharesize
				if(count($shares)==0)
				{
					Session::set_flash('error', 'You must enter a share size!');
					Response::redirect('yachtshare/create');																
				}

				//2.2 Now insert each share into the DB
				$i=1;
				$errors=0;
				foreach($shares as $share_size)
				{
					//If there are more than one shares to be inserted the append (#) to the name
					$name = (count($shares) > 1) ? Input::post('name')." (".$i.")" : Input::post('name');
					$i++;

					//Handle length field
					$length = (Input::post('length_unit') == 'm') ? Input::post("length") : round(Input::post("length")*0.3048,2);

					//If the user clicked "Save for later" button then insert this as a temporary yachtshare_create_form
					$save_for_later_clicked = (isset($_POST['save_for_later']));
					$submit_clicked = (isset($_POST['submit']));
					$from_temp_form = (Input::post('temp') == '1') ? true : false;

					//If this is updating a saved form and "Save for later" has been clicked
					if($from_temp_form and $save_for_later_clicked)
					{
						//echo "Updating an already saved temporary yachtshare";
						$yachtshare = $this->update_yachtshare_without_save(Input::post(),Input::post('yachtshare_id'),true);

					}elseif($from_temp_form and $submit_clicked)
					{
						//echo "Updating and setting temp=0 on already saved temporary yachtshare";
						$yachtshare = $this->update_yachtshare_without_save(Input::post(),Input::post('yachtshare_id'),false);

					}elseif(!$from_temp_form and $save_for_later_clicked)
					{
						//echo "Saving a yachtshare with temp=1";

					}elseif(!$from_temp_form and $submit_clicked)
					{
						//echo "Saving a yachtshare with temp=0";						

					}

					$yachtshare = Model_Yachtshare::forge(array(
						"name" 				=> $name,
						"make" 				=> Input::post("make"),
						"type" 				=> Input::post("type"),
						"location_general"	=> Input::post("location_general"),
						"location_specific" => Input::post("location_specific"),
						"length" 			=> $length,
						"price" 			=> $this->handle_price(Input::post("price")),
						"share_size" 		=> $share_size['float'],
						"share_size_num" 	=> $share_size['num'],
						"share_size_den" 	=> $share_size['den'],
						"boat_details"		=> json_encode($input),
						"user_id"			=> $this->user->id,
						"active"			=> true,
						"temp"				=> $save_for_later_clicked,
					));

					//Save
					($yachtshare->save()) or $errors++;
				}

				//Redirect
				if($errors > 0)
				{
					Session::set_flash('error', 'The yachtshare could not be created due to an error!');
					Response::redirect('yachtshare/create');											
				}else{
					//Delete the saved_form session
					Session::delete('buyer_create_form');

					Session::set_flash('success', 'Your yacht share(s) has been successfully added to the database!');
					$url = ($this->user->type == 'seller') ? 'seller' : 'yachtshare/view/'.$yachtshare->id;
					Response::redirect($url);						
				}


			//3. Or update the already existing yachtshare
			}elseif(Input::post('update')){
				$yachtshare = Model_Yachtshare::find(Input::post('yachtshare_id'));

				$length = (Input::post('length_unit') == 'm') ? Input::post("length") : round(Input::post("length")*0.3048,2);

				$yachtshare->name 				= Input::post('name');
				$yachtshare->make 				= Input::post('make');		
				$yachtshare->type 				= Input::post('type');		
				$yachtshare->location_general 	= Input::post('location_general');
				$yachtshare->location_specific 	= Input::post('location_specific');
				$yachtshare->length 			= $length;		
				$yachtshare->price 				= preg_replace("/,/","",Input::post("price"));		

				$yachtshare->share_size_num = Input::post("share_size_num");
				$yachtshare->share_size_den = Input::post("share_size_den");
				$yachtshare->share_size = $this->toFloat($yachtshare->share_size_num."/".$yachtshare->share_size_den);	

				$yachtshare->boat_details = json_encode($input);							

				//Redirect
				if($yachtshare->save())
				{
					Session::set_flash('success', 'The yacht share has been successfully updated!');
					Response::redirect('yachtshare/view/'.$yachtshare->id);											
				}else{
					Session::set_flash('error', 'The yachtshare could not be updated due to an error!');
					Response::redirect('yachtshare/edit/'.$yachtshare->id);						
				}
			}
		}
	}

	//Parameters: $post = Input::post()
	protected function update_yachtshare_without_save($post, $yachtshare_id, $temp=false)
	{
		$yachtshare = Model_Yachtshare::find($yachtshare_id);

		$length = (Input::post('length_unit') == 'm') ? Input::post("length") : round(Input::post("length")*0.3048,2);

		$yachtshare->name 				= Input::post('name');
		$yachtshare->make 				= Input::post('make');		
		$yachtshare->type 				= Input::post('type');		
		$yachtshare->location_general 	= Input::post('location_general');
		$yachtshare->location_specific 	= Input::post('location_specific');
		$yachtshare->length 			= $length;		
		$yachtshare->price 				= preg_replace("/,/","",Input::post("price"));		

		$yachtshare->share_size_num = Input::post("share_size_num");
		$yachtshare->share_size_den = Input::post("share_size_den");
		$yachtshare->share_size = $this->toFloat($yachtshare->share_size_num."/".$yachtshare->share_size_den);	

		$yachtshare->boat_details = json_encode($input);
		$yachtshare->temp = $temp;

		return $yachtshare;		
	}

	public function action_create()
	{
		if(Input::method() == 'POST')
		{
			$formfields = Model_Formfieldbuyer::find('all', array('order_by' => array('order' => 'ASC'), 'where' => array('belongs_to' => 'seller')));	
			$mysql_columns = array("name","make","type","location_general","location_specific","length","price","share_size","share_size_num","share_size_den");

			//1. Go through each formfield and extract the necessary data from POST input
			foreach($formfields as $field)
			{
				//Skip those which have their own mysql columns
				if(in_array($field->tag,$mysql_columns))
					continue;

				//Handle length input (i.e. meters/feet)
				if($field->type == 'length')
				{
					$input[$field->tag] = (Input::post($field->tag.'_unit') == 'm') ? Input::post($field->tag) : round(Input::post($field->tag)*0.3048,2);

				//Handle price input => remove commas
				}elseif($field->tag == 'price'){
					$input[$field->tag] = preg_replace(array('/,/','/\./'),"",Input::post($field->tag));

				//Or handle normal (direct) input
				}else{
					$input[$field->tag] = Input::post($field->tag);
				}
			}

			//2.1 Find out out many shares are to be inserted and what size each one is
			$shares = array();
			for($i=1; $i<=10; $i++)
			{
				if(Input::post("share_".$i."_num"))
				{
					$num = Input::post("share_".$i."_num");
					$den = Input::post("share_".$i."_den");
					$float = $this->toFloat($num."/".$den);

					$shares[] = array('num' => $num, 'den' => $den, 'float' => $float);
				}
			}				

			//Check that the user has inputted a sharesize
			if(count($shares)==0)
			{
				Session::set_flash('error', 'You must enter a share size!');
				Response::redirect('yachtshare/create');																
			}

			//2.2 Now insert each share into the DB
			$i=1;
			$errors=0;
			foreach($shares as $share_size)
			{
				//If there are more than one shares to be inserted the append (#) to the name
				$name = (count($shares) > 1) ? Input::post('name')." (".$i.")" : Input::post('name');
				$i++;

				//Handle length field
				$length = (Input::post('length_unit') == 'm') ? Input::post("length") : round(Input::post("length")*0.3048,2);

				//If the user clicked "Save for later" button then insert this as a temporary yachtshare_create_form
				$save_for_later_clicked = (isset($_POST['save_for_later']));

				if($save_for_later_clicked)
				{
					echo "Saving a yachtshare with temp=1";
				}else{
					echo "Saving a yachtshare with temp=0";
				}

				$yachtshare = Model_Yachtshare::forge(array(
					"name" 				=> $name,
					"make" 				=> Input::post("make"),
					"type" 				=> Input::post("type"),
					"location_general"	=> Input::post("location_general"),
					"location_specific" => Input::post("location_specific"),
					"length" 			=> $length,
					"price" 			=> $this->handle_price(Input::post("price")),
					"share_size" 		=> $share_size['float'],
					"share_size_num" 	=> $share_size['num'],
					"share_size_den" 	=> $share_size['den'],
					"boat_details"		=> json_encode($input),
					"user_id"			=> $this->user->id,
					"active"			=> true,
					"temp"				=> $save_for_later_clicked,
				));

				//Save
				($yachtshare->save()) or $errors++;
			}

			//Redirect
			if($errors > 0)
			{
				Session::set_flash('error', 'The yachtshare could not be created due to an error!');
				Response::redirect('yachtshare/create');											
			}else{
				//Delete the saved_form session
				Session::delete('buyer_create_form');

				if($yachtshare->temp == false)
				{
					//Send the automated email
					//1. Create an instance
					$email = Email::forge();

					//2. Populate email data
					$email->from($this->offline_config['from_email'], $this->offline_config['from_name']);
					$email->to($this->offline_config['admin_email']);
					$email->subject("New Yachtshare submitted by Seller");	
					$email->body("A new yachtshare has been submitted, view more at: ".Uri::create('yachtshare/view/'.$yachtshare->id));

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
				}

				Session::set_flash('success', 'Your yacht share(s) has been successfully added to the database!');
				$url = ($this->user->type == 'seller') ? 'seller' : 'yachtshare/view/'.$yachtshare->id;
				Response::redirect($url);						
			}			
		}
		//Session::delete('yachtshare_create_form');
		$this->logged_in_as(array('seller', 'admin'));

		$this->template->title = "Yachtshare: Create";
		$data['yachtshare'] = ($this->param('boat_id')) ? Model_Yachtshare::find((int) $this->param('boat_id')): Model_Yachtshare::forge();

		if($this->param('boat_id') and !$data['yachtshare'])
			throw new HttpNotFoundException;

		$data['location_general'] = array("UK","Mediterranean","Northern Europe","Caribbean","Only define specific area");
		$data['location_specific'] = array("UK: south-east","UK: south coast", "UK: west", "UK: Wales", "Greece", "Turkey", "Croatia", "France (Med Coast)", "France (Atlantic Coast)", "Spain");

		$data['user'] = $this->user;
		$data['formfields'] = $this->formfields;

		//If the user has specified which boat details are to be copied then retreive the details
		if($this->param('boat_id'))
		{
			$yachtshare = Model_Yachtshare::find($this->param('boat_id'));				

			foreach($this->formfields as $field)
			{
				$tag = $field->tag;
					//echo "This field ID#: ".$field->id." (".$field->label.") has a public value of ".$field->public." and so will be set to ";
				//If this is getting the data from an already entered "Live" yachtshare and the field is private then skip this row
				if($field->public == 0)
				{
					//echo "BLANK";
					$data['saved_form_data'][$tag] = '';
				}elseif($field->search_field)
				{
					//echo "a value";
					$data['saved_form_data'][$tag] = $yachtshare->$tag;
				}else{
					//echo "a value from an array";
					$data['saved_form_data'][$tag] = (isset($yachtshare->boat_details[$tag])) ? $yachtshare->boat_details[$tag] : '';
				}
				//echo "<br>";
			}
		}else{
			foreach($this->formfields as $field)
			{
				$data['saved_form_data'][$field->tag] = '';				
			}			
		}

		if($this->user->type == 'seller')
		{
			$this->template = \View::forge('public_template',array(),false);
			$this->template->user = $this->user;
			$this->template->form_page = true;												//To set the html body to display "are you sure" popup on exit

			if($data['yachtshare']->temp)
			{
				$this->template->title = 'Yacht Fractions: Your saved (but incomplete) yachtshare';
				$this->template->content = View::forge('yachtshare/seller/update_incomplete_form',$data,false);				
			}else{
				$this->template->title = 'Yacht Fractions: Create Yachtshare';
				$this->template->content = View::forge('yachtshare/seller/create',$data,false);
			}
		}else{
			$data['types'] = array("Sailing boats shares UK", "Sailing boat shares overseas", "Motor boat shares UK", "Used Yacht on brokerage", "Used yacht in Greece", "Used yacht - private sale");
			$this->template->links['shares']['current'] = true;
			$this->template->content = View::forge('yachtshare/admin/create',$data, false);
		}
	}

	public function action_edit($id = null)
	{
		$this->logged_in_as(array('seller', 'admin'));
		if(is_null($id))
			throw new HttpNotFoundException;

		$data['yachtshare'] = Model_Yachtshare::find($id);

		if(!$data['yachtshare'])
			throw new HttpNotFoundException;


		$data['formfields'] = $this->formfields;
		$data['user'] = $this->user;
		$this->template->title = "Yachtshare: ".$data['yachtshare']->name;

		if($this->user->type == 'seller')
		{
			$this->template = \View::forge('public_template',array(),false);
			$this->template->user = $this->user;
			$this->template->title = 'Yacht Fractions: Viewing Yachtshare';
			$this->template->content = View::forge('yachtshare/seller/edit',$data,false);
		}elseif($this->user->type == 'admin'){
			$this->template->links['shares']['current'] = true;
			$this->template->content = View::forge('yachtshare/admin/edit',$data,false);
		}
	}

	public function action_deactivate($id = null)
	{
		$this->logged_in_as(array('admin'));
		if ($yachtshare = Model_Yachtshare::find($id))
		{
			$query = DB::query('UPDATE `yachtshares` SET active = NOT active WHERE id='.$id);
			
			if($query->execute())
			{
				$word = ($yachtshare->active == 1) ? 'Deactived' : 'Activated';
				Session::set_flash('success', $word.' yachtshare #'.$id);
				$url = ($yachtshare->active == 1) ? 'yachtshare/view/'.$id : 'yachtshare/view/'.$id;
			}else{
				Session::set_flash('error', 'Could not deactivate yachtshare #'.$id);
				$url = 'yachtshare/view/'.$id;
			}
		}

		else
		{
			Session::set_flash('error', 'Could not deactivate yachtshare #'.$id);
			$url = 'yachtshare/view/'.$id;
		}

		Response::redirect($url);

	}

	public function action_delete($id = null)
	{
		$this->logged_in_as(array('admin','seller'));

		if ($yachtshare = Model_Yachtshare::find($id))
		{

			if(($this->user->type == 'seller') and ($yachtshare->user_id != $this->user->id))
			{
				Session::set_flash('error', 'You do not have permission to delete that yachtshare!');
				Response::redirect('seller');				
			}

			$yachtshare->delete();

			Session::set_flash('success', 'Deleted yachtshare #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete yachtshare #'.$id);
		}

		$url = ($this->user->type == 'admin') ? 'yachtshare' : 'seller';
		Response::redirect($url);
	}


	public function action_update()
	{
		$this->logged_in_as(array('seller'));
		$yachtshare = Model_Yachtshare::find((int) $this->param('boat_id'));

		if(!$yachtshare)
			throw new HttpNotFoundException;

		if($yachtshare->user_id != $this->user->id)
		{
			Session::set_flash('error', 'You do not have permission to access that page!');
			Response::redirect('seller');
		}

		if(Input::method() == 'POST')
		{
			$formfields = Model_Formfieldbuyer::find('all', array('order_by' => array('order' => 'ASC'), 'where' => array('belongs_to' => 'seller')));	
			$mysql_columns = array("name","make","type","location_general","location_specific","length","price","share_size","share_size_num","share_size_den");

			//1. Go through each formfield and extract the necessary data from POST input
			foreach($formfields as $field)
			{
				//Skip those which have their own mysql columns
				if(in_array($field->tag,$mysql_columns))
					continue;

				//Handle length input (i.e. meters/feet)
				if($field->type == 'length')
				{
					$input[$field->tag] = (Input::post($field->tag.'_unit') == 'm') ? Input::post($field->tag) : round(Input::post($field->tag)*0.3048,2);

				//Handle price input => remove commas
				}elseif($field->tag == 'price'){
					$input[$field->tag] = preg_replace(array('/,/','/\./'),"",Input::post($field->tag));

				//Or handle normal (direct) input
				}else{
					$input[$field->tag] = Input::post($field->tag);
				}
			}

			$yachtshare = Model_Yachtshare::find(Input::post('yachtshare_id'));

			$length = (Input::post('length_unit') == 'm') ? Input::post("length") : round(Input::post("length")*0.3048,2);

			$yachtshare->name 				= Input::post('name');
			$yachtshare->make 				= Input::post('make');		
			$yachtshare->type 				= Input::post('type');		
			$yachtshare->location_general 	= Input::post('location_general');
			$yachtshare->location_specific 	= Input::post('location_specific');
			$yachtshare->length 			= $length;		
			$yachtshare->price 				= preg_replace("/,/","",Input::post("price"));		

			$yachtshare->share_size_num = Input::post("share_size_num");
			$yachtshare->share_size_den = Input::post("share_size_den");
			$yachtshare->share_size = $this->toFloat($yachtshare->share_size_num."/".$yachtshare->share_size_den);	

			$yachtshare->boat_details = json_encode($input);							

			$save_for_later_clicked = (isset($_POST['save_for_later']));
			$yachtshare->temp = $save_for_later_clicked;

			//Redirect
			if($yachtshare->save())
			{
				if($yachtshare->temp == false)
				{
					//Send the automated email
					//1. Create an instance
					$email = Email::forge();

					//2. Populate email data
					$email->from($this->offline_config['from_email'], $this->offline_config['from_name']);
					$email->to($this->offline_config['admin_email']);
					$email->subject("New Yachtshare submitted by Seller");	
					$email->body("A new yachtshare has been submitted, view more at: ".Uri::create('yachtshare/view/'.$yachtshare->id));

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
				}

				Session::set_flash('success', 'The yacht share has been successfully updated!');
				Response::redirect('seller');											
			}else{
				Session::set_flash('error', 'The yachtshare could not be updated due to an error!');
				Response::redirect('yachtshare/update/'.$yachtshare->id);						
			}			
		}

		$data['user'] = $this->user;
		$data['saved_form_data'] = array();
		$this->logged_in_as(array('seller', 'admin'));
		//$this->template->title = "Yachtshare: Create";
		$data['yachtshare'] = $yachtshare;
		$data['formfields'] = $this->formfields;

		foreach($this->formfields as $field)
		{
			$tag = $field->tag;
			if($field->search_field)
			{
				//echo "a value";
				$data['saved_form_data'][$tag] = $data['yachtshare']->$tag;
			}else{
				//echo "a value from an array";
				$data['saved_form_data'][$tag] = (isset($data['yachtshare']->boat_details[$tag])) ? $data['yachtshare']->boat_details[$tag] : '';
			}
		}

		$this->template = \View::forge('public_template',array(),false);
		$this->template->user = $this->user;
		$this->template->form_page = true;												//To set the html body to display "are you sure" popup on exit

		$this->template->title = 'Yacht Fractions: Your saved (but incomplete) yachtshare';
		$this->template->content = View::forge('yachtshare/seller/update_incomplete_form',$data,false);				
	}
}
