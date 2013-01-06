<?php
class Controller_Boat extends MyController 
{
	public function before(){
		parent::before();

		$this->template->links['boats']['current'] = true;
	}

	public function action_index()
	{
		$data['boats'] = Model_Boat::find('all', array('related' => 'shares'));
		$this->template->title = "Boats";
		$this->template->content = View::forge('boat/index', $data);
	}

	public function action_view($id = null)
	{
		is_null($id) and Response::redirect('Boat');

		$boat = Model_Boat::find($id);
		$data['boat'] = $boat;
		$data['fields'] = $boat->fields();

		$this->template->title = "Boat";
		$this->template->content = View::forge('boat/view', $data, false);

	}

	public function action_create()
	{
		$formfields = Model_Formfield::find('all', array("order_by" => "order"));

		if (Input::method() == 'POST')
		{
				$inputfields = array();
				foreach($formfields as $formfield)
				{
					$value = Input::post('field_'.$formfield->id);
					(empty($value)) or $inputfields[$formfield->key] = $value;
				}	
	
				$boat = Model_Boat::forge(array(
					'name' => 			Input::post('name'),
					'location' => 		Input::post('location'),
					'description' => 	json_encode($inputfields),
					'length' => 		Input::post('length'),
				));

				if ($boat and $boat->save())
				{
					Session::set_flash('success', 'Added boat #'.$boat->id.'.');

					Response::redirect('boat/view/'.$boat->id);
				}
				else
				{
					Session::set_flash('error', 'Could not save boat.');
				}
		}

		$this->template->title = "Boats";
		$data['formfields'] = $formfields;
		$this->template->content = View::forge('boat/create', $data);

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('Boat');

		$boat = Model_Boat::find($id);
		$formfields = Model_Formfield::find('all', array("order_by" => "order"));

		if (Input::method() == 'POST')
		{
			$boat->name = Input::post('name');
			$boat->location = Input::post('location');
			$boat->length = Input::post('length');

			//Parse the proforma fields
			$input = array();
			foreach($formfields as $formfield)
			{
				$value = Input::post('field_'.$formfield->id);
				(empty($value)) or $input[$formfield->key] = $value;
			}

			$boat->description = json_encode($input);

			//echo "<pre>";
			//print_r($input);
			//exit;

			if ($boat->save())
			{
				Session::set_flash('success', 'Updated boat #' . $id);

				Response::redirect('boat/view/'.$id);
			}

			else
			{
				Session::set_flash('error', 'Could not update boat #' . $id);
			}
		}

	

		$data['boat'] = $boat;
		$data['fields'] = $boat->fields(true);

		foreach($formfields as $field){
			isset($data['fields'][$field->key]) or $data['fields'][$field->key] = "";
		}

		$this->template->title = "Boats";
		$data['formfields'] = $formfields;
		$this->template->content = View::forge('boat/edit', $data);

	}

	public function action_delete($id = null)
	{
		if ($boat = Model_Boat::find($id))
		{
			$boat->delete();

			Session::set_flash('success', 'Deleted boat #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete boat #'.$id);
		}

		Response::redirect('boat');

	}

	//This checks that all the images have been uploaded correctly
	public function action_importcheck()
	{
		$images = Model_Image::find('all');

		$errors = array();
		foreach($images as $image)
		{
			if(!file_exists("uploads/".$image->url))
				$errors[] = array("Image file" => "http://www.yachtfractions.co.uk/images".$image->url, "Boat_id" => $image->boat_id);
				//$image->delete();
		}

		echo "<pre>";
		print_r($errors);
		exit;
	}

	public function action_import()
	{
		//$this->import("http://www.yachtfractions.co.uk/OS/sail.asp","Sailing boat shares overseas","Mediterranean", "Greece");
		$this->import("http://www.yachtfractions.co.uk/UK/sail.asp","Sailing boat shares UK","UK", "UK: south coast");
		$this->import("http://www.yachtfractions.co.uk/MY/sail.asp","Motor boat shares UK","UK", "UK: south coast");
	}
}