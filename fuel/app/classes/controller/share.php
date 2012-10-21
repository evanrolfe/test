<?php
class Controller_Share extends MyController 
{
	public function before(){
		parent::before();
	}

	public function action_index()
	{
		$this->template->links['shares']['current'] = true;


		$query = DB::query('SELECT shares.fraction,boat_id,shares.id AS id, boats.location, boats.name FROM `shares` LEFT JOIN `boats` ON (shares.boat_id=boats.id) WHERE boats.location LIKE "%(UK)%"');

		$shares = Model_Share::find('all');//$query->as_assoc()->execute();

		$data['available_actionsteps'] = Model_Asname::find('all');

		$this->template->title = "Shares";
		$this->template->content = View::forge('share/index', $data);

		$this->template->content->set('shares', $shares, false);
	}

	public function action_boat()
	{
		is_null($this->param('boat_id')) and Response::redirect('boat');
		$this->template->links['boats']['current'] = true;

		$data['available_actionsteps'] = Model_Asname::find('all');
		$data['boat'] = Model_Boat::find($this->param('boat_id'));
		$this->template->title = "Shares";
		$this->template->content = View::forge('share/boat', $data);
	}

	public function action_view($id = null)
	{
		$data['share'] = Model_Share::find($id);

		is_null($id) and Response::redirect('Share');

		$this->template->title = "Share";
		$this->template->content = View::forge('share/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			$val = Model_Share::validate('create');
			
			if ($val->run())
			{
				$share = Model_Share::forge(array(
					'boat_id' => Input::post('boat_id'),
					'buyer_id' => Input::post('buyer_id'),
					'fraction' => Input::post('fraction'),
				));

				if ($share and $share->save())
				{
					Session::set_flash('success', 'Added share #'.$share->id.'.');

					Response::redirect('share');
				}

				else
				{
					Session::set_flash('error', 'Could not save share.');
				}
			}
			else
			{
				Session::set_flash('error', $val->error());
			}
		}

		$data = array();
		$data['boats'] = Model_Boat::find('all');
		$this->template->title = "Shares";
		$this->template->content = View::forge('share/create',$data);
	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('Share');

		$share = Model_Share::find($id);

		$val = Model_Share::validate('edit');

		if ($val->run())
		{
			$share->boat_id = Input::post('boat_id');
			$share->buyer_id = Input::post('buyer_id');
			$share->fraction = Input::post('fraction');

			if ($share->save())
			{
				Session::set_flash('success', 'Updated share #' . $id);

				Response::redirect('share');
			}

			else
			{
				Session::set_flash('error', 'Could not update share #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$share->boat_id = $val->validated('boat_id');
				$share->buyer_id = $val->validated('buyer_id');
				$share->fraction = $val->validated('fraction');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('share', $share, false);
		}

		$this->template->title = "Shares";
		$this->template->content = View::forge('share/edit');

	}

	public function action_delete($id = null)
	{
		if ($share = Model_Share::find($id))
		{
			$share->delete();

			Session::set_flash('success', 'Deleted share #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete share #'.$id);
		}

		Response::redirect('share');

	}


}
