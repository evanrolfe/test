<?php
class Controller_Actionstep extends MyController 
{

	public function before(){
		parent::before();
		$this->logged_in_as(array('admin'));
		//$this->template->links['shares']['current'] = true;
	}

	public function action_index()
	{
		$data['actionsteps'] = Model_Actionstep::find('all');
		$this->template->title = "Actionsteps";
		$this->template->content = View::forge('actionstep/index', $data);

	}

	public function action_view($id = null)
	{
		$data['actionstep'] = Model_Actionstep::find($id);

		is_null($id) and Response::redirect('Actionstep');

		$this->template->title = "Actionstep";
		$this->template->content = View::forge('actionstep/view', $data);

	}

	public function action_create()
	{
		if (Input::method() == 'POST')
		{
			//Defaults: these inputs are the same for all types
			//Field: 'occured_at'
			$time = explode("/", Input::post('date'));
			$occured_at= ((Input::post('date')) != "") ? mktime(0,0,0,(int)$time[1],(int)$time[0],(int)$time[2]) : time();

			//Types can be one of 'introduction', 'action', 'hold', 'note'

			//Type: 'note'
			$asname = Model_Asname::find(Input::post('actionstep_set_id'));
			if(Input::post('note_only')=='1'){				
				$type = 'note';
				$title = 'Note';
				$expires_at = 0;
				$actionstep_set_id = 0;			

			//Type: 'hold'
			}elseif((Input::post('hold_days') || Input::post('hold_hours')) and Input::post('introduction') != '1'){
				$type = 'hold';
				$title = 'On Hold';
				$actionstep_set_id = 0;

				//Calculate the datetime at which the hold will expire and save this in expires_at
				$hours = (int)Input::post('hold_days')*24+(int)Input::post('hold_hours');
				$expires_at = strtotime('+'.$hours.' hours', time());;

			//TYPE: 'action'
			}elseif($asname and $asname->order > 1)
			{
				$type = 'action';
				$title = $asname->title;
				$expires_at = 0;
				$actionstep_set_id = $asname->id;

			//Type: 'introduction'
			}elseif(Input::post('introduction') == '1'){
				$asname = Model_Asname::find(1);
				$type = 'introduction';
				$title = $asname->title;
				$expires_at = 0;
				$actionstep_set_id = $asname->id;

			//Type: 'cancel'
			}elseif(Input::post('cancel') == '1'){
				$type = 'cancel';
				$title = 'Cancelled';
				$expires_at = 0;
				$actionstep_set_id = 0;

				Model_Actionstep::cancel(Input::post('buyer_id'),Input::post('boat_share_id'), 'cancel');

			//Type: 'complete'
			}elseif(Input::post('complete') == '1'){
				$type = 'complete';
				$title = 'Sale Completed';
				$expires_at = 0;
				$actionstep_set_id = 0;

				Model_Actionstep::cancel(Input::post('buyer_id'),Input::post('boat_share_id'), 'complete');
			}

			$actionstep = Model_Actionstep::forge(array(
				'title' => $title,
				'note' => Input::post('note'),
				'type' => $type,
				'boat_share_id' => Input::post('boat_share_id'),
				'buyer_id' => Input::post('buyer_id'),
				'actionstep_set_id' => $actionstep_set_id,
				'expires_at' => $expires_at,
				'occurred_at' => $occured_at,
			));

			//If this is an introduction WITH a hold
			if((Input::post('hold_days') || Input::post('hold_hours')) and Input::post('introduction') == '1'){
				//Calculate the datetime at which the hold will expire and save this in expires_at
				$hours = (int)Input::post('hold_days')*24+(int)Input::post('hold_hours');
				$expires_at = strtotime('+'.$hours.' hours', time());;

				$hold_actionstep = Model_Actionstep::forge(array(
					'title' => 'On Hold',
					'note' => '',
					'type' => 'hold',
					'boat_share_id' => Input::post('boat_share_id'),
					'buyer_id' => Input::post('buyer_id'),
					'actionstep_set_id' => 0,
					'expires_at' => $expires_at,
					'occurred_at' => $occured_at,
				));

				$hold_actionstep->save();
			}

			$from_page = Input::post('from_page');
			if(isset($_POST['email']))
			{
				$url = '/email/create/template/1/'.Input::post('buyer_id').'/'.Input::post('boat_share_id').'/'.$from_page;
			}else{
				if($from_page == 'yachtshare')
				{
					$url = 'yachtshare/view/'.Input::post('boat_share_id');
				}else{
					$url = 'buyer/view/'.Input::post('buyer_id');					
				}
			}

			//If there are actionsteps that need to be inserted before this one
			$previous_steps = $actionstep->previous_active_ones();
			if(count($previous_steps) > 0){

				foreach($previous_steps as $step){
					$prev_actionstep = Model_Actionstep::forge(array(
						'title' => $step->title,
						'note' => '',
						'type' => 'action',
						'boat_share_id' => Input::post('boat_share_id'),
						'buyer_id' => Input::post('buyer_id'),
						'actionstep_set_id' => $step->id,
						'occurred_at' => $occured_at,
					));
					$prev_actionstep->save();					
				}
			}

			if ($actionstep and $actionstep->save())
			{
				Session::set_flash('success', 'Added actionstep #'.$actionstep->id.'.');

				Response::redirect($url);
			}
			else
			{
				Session::set_flash('error', 'Could not save actionstep.');
			}
		}else{

		$data['actionsteps'] = Model_Actionstep::available($this->param('buyer_id'),$this->param('boat_share_id'));
		$data['buyer'] = Model_Buyer::find($this->param('buyer_id'));

		$data['selected_actionstep'] = $this->param('actionstep');
		$data['from_page'] = $this->param('from_page');

		//If there is no buyer selected then retreive data for all of them for dropdown
		if(!$data['buyer'])
			$data['buyers'] = Model_Buyer::find('all');

		$data['yachtshare'] = Model_Yachtshare::find($this->param('boat_share_id'));
		//$data['available_actionsteps'] = Model_Asname::find('all', array('order_by' => array('order' => 'ASC')));
		$this->template->title = "Actionstep Create";
		$this->template->content = View::forge('actionstep/create', $data, false);
		}
	}

	public function action_edit($id = null)
	{
		is_null($id) and Response::redirect('Actionstep');

		$actionstep = Model_Actionstep::find($id);

		$val = Model_Actionstep::validate('edit');

		if ($val->run())
		{
			$actionstep->title = Input::post('title');
			$actionstep->note = Input::post('note');
			$actionstep->boat_share_id = Input::post('boat_share_id');
			$actionstep->buyer_id = Input::post('buyer_id');

			if ($actionstep->save())
			{
				Session::set_flash('success', 'Updated actionstep #' . $id);

				Response::redirect('actionstep');
			}

			else
			{
				Session::set_flash('error', 'Could not update actionstep #' . $id);
			}
		}

		else
		{
			if (Input::method() == 'POST')
			{
				$actionstep->title = $val->validated('title');
				$actionstep->note = $val->validated('note');
				$actionstep->boat_share_id = $val->validated('boat_share_id');
				$actionstep->buyer_id = $val->validated('buyer_id');

				Session::set_flash('error', $val->error());
			}

			$this->template->set_global('actionstep', $actionstep, false);
		}

		$this->template->title = "Actionsteps";
		$this->template->content = View::forge('actionstep/edit');

	}

	public function action_delete()
	{
		$id = $this->param('id');
		$from_page = $this->param('from_page');

		if ($actionstep = Model_Actionstep::find($id))
		{
			$actionstep->delete();

			Session::set_flash('success', 'Deleted actionstep #'.$id);
		}

		else
		{
			Session::set_flash('error', 'Could not delete actionstep #'.$id);
		}

		$url = ($from_page == 'yachtshare') ? 'yachtshare/view/'.$actionstep->boat_share_id : 'buyer/view/'.$actionstep->buyer_id;
		Response::redirect($url);

	}


}
