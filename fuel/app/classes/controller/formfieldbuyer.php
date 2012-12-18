<?php
class Controller_Formfieldbuyer extends MyController 
{
	public function before(){
		parent::before();

		$this->template->links['settings']['current'] = true;
		$this->logged_in_as(array('admin'));
	}
	
	public function action_dropdown()
	{
		$id = $this->param('id');

		if(is_null($id))
			throw new HttpNotFoundException;

		$field = Model_Formfieldbuyer::find($id);

		if(!$field)
			throw new HttpNotFoundException;
	
		$data['close_window'] = 'false';

		if(Input::method() == 'POST')
		{
		
			//$query = DB::query("UPDATE `formfields_buyer` SET options='".Input::post('options')."' WHERE id=".$id);
			//$query->execute();

			$field->options = Input::post('options');

			if($field->save())
			{
				$data['close_window'] = 'true';
			}else{
				exit("Error");
			}
		}

		$data['field'] = $field;
		$data['field']->options = json_encode($field->options);
		$this->template->title = "Form Fields";
		return new Response(View::forge('formfieldbuyer/dropdown_order',$data,false));				
	}

	public function action_index()
	{
		$data['seller_fields'] = Model_Formfieldbuyer::find('all', array("order_by" => "order", "where" => array("belongs_to" => "seller")));
		$data['buyer_fields'] = Model_Formfieldbuyer::find('all', array("order_by" => "order", "where" => array("belongs_to" => "buyer")));
		$this->template->title = "Form Fields";
		$this->template->content = View::forge('formfieldbuyer/index', $data);		
	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
				switch(Input::post('type'))
				{
					case 'text':
						$options = '';
					break;

					case 'textarea':
						$options = Input::post('rows');
					break;		

					case 'text_fraction':
						$options = '';
					break;		

					case 'dropdown':
						$options = (Input::post('dropdown_linked') == "") ? Input::post('selected_options') : "ID:".Input::post('dropdown_linked');
					break;							
				}

				echo "DROPDOWN LINKED: ".Input::post('dropdown_linked');

				$public = (Input::post('public')) ? 1 : 0;

				if(Input::post('type')=='terms_and_conditions')
				{	
					$required = 'required';
					$label = 'Terms and Conditions';
					$description = Input::post('terms_and_conditions');
					$tag = 'terms_and_conditions';

					if(count(Model_Formfieldbuyer::find('all',array('where' => array('belongs_to' => Input::post('belongs_to'), 'tag' => 'terms_and_conditions')))) > 0)
					{
						Session::set_flash('error', 'You may only have one terms and conditions field for the buyer form and seller form.');
						Response::redirect('formfieldbuyer/create');
					}
				}else{
					$required = (Input::post('required')) ? 'required' : '';
					$label = Input::post('label');
					$description = Input::post('description');
					$tag = Input::post("tag");
				}

				$formfield = Model_Formfieldbuyer::forge(array(
					'label' => $label,
					'tag' => $tag,
					'type' => Input::post('type'),
					'belongs_to' => Input::post('belongs_to'),
					'description' => $description,
					'validation' => $required,
					'options' => $options,
					'search_field' => 0,
					'public' => $public,
				));

				if ($formfield and $formfield->save())
				{
					Session::set_flash('success', 'Added formfield #'.$formfield->id.'.');

					Response::redirect('formfieldbuyer');
				}

				else
				{
					Session::set_flash('error', 'Could not save formfield.');
				}
		}

		(is_null($this->param('belongs_to')) || !in_array($this->param('belongs_to'), array('buyer','seller'))) and Response::redirect('formfieldbuyer');

		$dropdowns = Model_Formfieldbuyer::find('all', array('where' => array('type' => 'dropdown')));
		//Remove the ones that have linked options
		$data['formfields_dropdowns'] = array();
		foreach($dropdowns as $ffield)
		{
			if(!$ffield->are_options_linked)
				$data['formfields_dropdowns'][] = $ffield;
		}

		$data['belongs_to'] = $this->param('belongs_to');
		$this->template->title = "Form Fields";
		$this->template->content = View::forge('formfieldbuyer/create',$data);	
	}

	public function action_order()
	{
		if (Input::method() == 'POST')
		{
				//1. Extract the order of fields
				$order = Input::post('order');
				$order = explode("&",$order);

				for($i=0; $i<count($order); $i++){
					$order[$i] = substr($order[$i],8);
				}

				//echo "<pre>";
				//print_r($order);
				//exit;

				//2. Update the database accordingly
				$db = array();
				$errors = 0;
				for($i=1; $i<=count($order); $i++){
					$id = (int) $order[$i-1];

					//$formfield = Model_Formfieldbuyer::find($id);
					//$formfield->order = $i;
					//echo "Setting formfield #".$formfield->id." to order #".$formfield->order."<br>";
					//$formfield->save();

					DB::update('formfields_buyer')->value('order',$i)->where('id','=',$id)->execute();
				}

				if($errors == 0){
					Session::set_flash('success', "The order of the buyer fields has been successfully changed.");
				}else{
					Session::set_flash('error', "The order of the buyer fields could not be changed due to an error.");
				}
				Response::redirect('formfieldbuyer');

		}

		if(is_null($this->param('belongs_to')) || !in_array($this->param('belongs_to'), array('buyer','seller')))
			throw new HttpNotFoundException;

		$data['belongs_to'] = $this->param('belongs_to');
		$data['formfields'] = Model_Formfieldbuyer::find('all', array("order_by" => "order", "where" => array("belongs_to" => $this->param('belongs_to'))));
		$this->template->title = "Form Fields";
		$this->template->content = View::forge('formfieldbuyer/order',$data);	
	}

	public function action_test()
	{
		$dropdowns = Model_Formfieldbuyer::find('all', array('where' => array('type' => 'dropdown')));		

		foreach($dropdowns as $field)
		{
			echo $field->id."; ".$field->label."<br>";
			echo "<pre>";
			print_r($field->options);
			echo "</pre>";
			
		}
		exit;
	}

	public function action_edit($id = null)
	{
		if(is_null($id))
			throw new HttpNotFoundException;

		$field = Model_Formfieldbuyer::find($id);

		if(!$field)
			throw new HttpNotFoundException;

		if(Input::method() == 'POST')
		{
			$field->label = Input::post('label');
			//$field->tag = Input::post('tag');
			$field->type = Input::post('type');
			$field->description = Input::post('description');
			$field->options = (Input::post('are_options_linked') == '1') ? "ID:".Input::post('linked_options') : Input::post('options');			
			$field->public = (Input::post('public')) ? 1 : 0;
     	 	$field->validation = (Input::post('required')) ? 'required' : '';	

			if($field->save())
			{
				Session::set_flash('success', 'Updated form field: ' . $field->label.', Click the blue "Forms" button below to go back.');

				Response::redirect('formfieldbuyer/edit/'.$id);				
			}else{
				Session::set_flash('error', 'Error: could not update form field #' . $id);				
			}
		}

		$dropdowns = Model_Formfieldbuyer::find('all', array('where' => array('type' => 'dropdown')));

		//Remove the ones that have linked options
		$data['formfields_dropdowns'] = array();
		foreach($dropdowns as $ffield)
		{
			if(!$ffield->are_options_linked)
				$data['formfields_dropdowns'][] = $ffield;
		}
		$data['field'] = $field;

		//Decode the json
		if($field->type == 'dropdown')
			$data['field']->options = json_encode($data['field']->options);


		$this->template->title = "Form Fields";
		$this->template->content = View::forge('formfieldbuyer/edit',$data,false);			
	}

	public function action_delete($id = null)
	{
		if(is_null($id))
			throw new HttpNotFoundException;

		if ($field = Model_Formfieldbuyer::find($id))
		{
			$field->delete();

			Session::set_flash('success', 'Deleted form field #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete form field #'.$id);
		}

		Response::redirect('formfieldbuyer');

	}
}
