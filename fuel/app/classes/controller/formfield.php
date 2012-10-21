<?php
class Controller_Formfield extends MyController 
{
	public function before(){
		parent::before();

		$this->template->links['settings']['current'] = true;
	}

	public function action_index()
	{
		$data['seller_fields'] = Model_Formfield::find('all', array("order_by" => "order"));
		$data['buyer_fields'] = Model_Formfieldbuyer::find('all', array("order_by" => "order"));
		$this->template->content = View::forge('formfield/index', $data);
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


				//2. Update the database accordingly
				$db = array();
				for($i=1; $i<=count($order); $i++){
					$id = (int) $order[$i-1];

					$formfield = Model_Formfield::find($id);
					$formfield->order = $i;
					$formfield->save();
				}

				//echo "<pre>";
				//print_r($order);
				//exit;

				Session::set_flash('success', "The order of the proforma fields has been successfully changed.");

				Response::redirect('formfield');

		}else{
			$data['formfields'] = Model_Formfield::find('all', array("order_by" => "order"));
			$this->template->title = "Formfields";
			$this->template->content = View::forge('formfield/order', $data);
		}
	}

	public function action_view($id = null)
	{
		$data['formfield'] = Model_Formfield::find($id);

		is_null($id) and Response::redirect('Formfield');

		$this->template->title = "Formfield";
		$this->template->content = View::forge('formfield/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Formfield::validate('create');
			
			if ($val->run())
			{
				$formfield = Model_Formfield::forge(array(
					'key' => Input::post('key'),
				));

				if ($formfield and $formfield->save())
				{
					Session::set_flash('success', 'Added formfield #'.$formfield->id.'.');

					Response::redirect('formfield');
				}

				else
				{
					Session::set_flash('error', 'Could not save formfield.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$this->template->title = "Formfields";
		$this->template->content = View::forge('formfield/create');

	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('Formfield');

		$formfield = Model_Formfield::find($id);

		$val = Model_Formfield::validate('edit');

		if ($val->run())
		{
			$formfield->key = Input::post('key');
			$formfield->value = Input::post('value');
			$formfield->type = Input::post('type');
			$formfield->required = Input::post('required');

			if ($formfield->save())
			{
				Session::set_flash('success', 'Updated formfield #' . $id);

				Response::redirect('formfield');
			}

			else
			{
				Session::set_flash('error', 'Could not update formfield #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$formfield->key = $val->validated('key');
				$formfield->value = $val->validated('value');
				$formfield->type = $val->validated('type');
				$formfield->required = $val->validated('required');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('formfield', $formfield, false);
		}

		$this->template->title = "Formfields";
		$this->template->content = View::forge('formfield/edit');

	}

	public function action_delete($id = null)
	{
		if ($formfield = Model_Formfield::find($id))
		{
			$formfield->delete();

			Session::set_flash('success', 'Deleted formfield #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete formfield #'.$id);
		}

		Response::redirect('formfield');

	}


}
