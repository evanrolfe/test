<?php
class Controller_Data extends MyController 
{
	public function before(){
		parent::before();

		$this->template->links['settings']['current'] = true;
		$this->logged_in_as(array('admin'));
	}

	public function action_index()
	{
		$data = array();
		$data['backups'] = Model_Backup::find('all', array("order_by" => array("created_at" => "DESC"))); 
		$this->template->title = "Data Management";
		$this->template->content = View::forge('data/index', $data);		
	}

	public function action_export()
	{
		$date = Date::forge()->format("%d-%m-%Y %H:%m");
		header('Content-type: text/plain');
		header('Content-Disposition: attachment; filename="backup at '.$date.'.sql"');	

		$backup = Model_Backup::forge(array(
			'note' =>'',
			'type' => 'export',
		));

		$backup->save();

		echo passthru('mysqldump --host=localhost --user=root --password=pass fuel_dev');
		//Response::redirect('data');
	}

	public function action_import()
	{
		if(Input::method() == 'POST')
		{
			// Custom configuration for this upload
			$config = array(
				'path' => DOCROOT.'uploads',
				'randomize' => true,
			);

			$backup = Model_Backup::forge(array(
				'note' =>'',
				'type' => 'import',
			));

			$backup->save();

			// process the uploaded files in $_FILES
			Upload::process($config);

			// if there are any valid files then save them
			//(Upload::is_valid()) and Upload::save();

			$errors = 0;
			foreach(Upload::get_files() as $file)
			{
				$sql = File::read($file['file'],true);

				$query = DB::query($sql);

				if(!$query->execute())
					$errors++;
			}

			if($errors == 0)
			{
					Session::set_flash('success', 'The backup file has been succesfully restored.');				
			}else{
					Session::set_flash('error', 'The database could not be updated due to an error!');				
			}

			Response::redirect('data');
		}

		$data = array(); 
		$this->template->title = "Data Management";
		$this->template->content = View::forge('data/import', $data);		
	}

	public function action_print()
	{
		$type = $this->param('type');

		$data['yachtshare'] = Model_Yachtshare::find($this->param('yachtshare_id'));

		$res = $data['yachtshare']->sold_to();
		$buyer_id = $res[0]['buyer_id'];

		$data['buyer'] = Model_Buyer::find($buyer_id);

		if($type == 'invoice')
		{
			return new Response(View::forge('data/mobile_invoice',$data));
		}elseif($type=='letter_buyer')
		{
			return new Response(View::forge('data/buyers_letter',$data));			
		}elseif($type=='letter_seller')
		{
			return new Response(View::forge('data/sellers_letter',$data));			
		}
	}
}
