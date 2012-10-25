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

		$data['offline'] = $this->offline;

		$this->template->title = "Data Management";
		$this->template->content = View::forge('data/index', $data);		
	}

	public function action_cols()
	{
		$columns = DB::list_columns('asnames');		

		echo "<pre>";
		print_r($columns);
		echo "</pre>";

		exit;
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

		echo $this->get_sql_string();
		exit;
	}

	public function get_sql_string()
	{
		//1. Get the table names
		$tables = array('actionsteps','asnames','buyers','emails','emailtemplates','formfields_buyer','images','yachtshares');


		$out = "";
		foreach($tables as $table)
		{
			if(in_array($table, array('shares','sessions', 'migration','backups','users'))) //'yachtshares','buyers','formfields_buyer','emailtemplates',
				continue;

			$out .= "TRUNCATE `".$table."`;";

			$out .= "INSERT INTO `".$table."` (";
			$columns = DB::list_columns($table);

			$i=1;
			foreach($columns as $key => $col)
			{
				$out .= "`".$key."`";
				if($i < count($columns))
					$out .= ", ";
				$i++;
			}
			
			$out .= ") VALUES ";
	
			$rows = DB::query('SELECT * FROM `'.$table.'`',DB::SELECT)->execute();

			$j=1;
			foreach($rows as $row)
			{
				$out .= "(";
				$i=1;
				foreach($columns as $key => $col)
				{
					$val = (is_null($row[$key])) ? "NULL" : $row[$key];


					if($col['type'] == 'string')
					{
						//$val = Security::clean($val, array('strip_tags', 'htmlentities'));
						$val = addslashes($val);
						$out .= "'".$val."'";
					}else{
						$out .= $val;
					}

					if($i < count($columns))
						$out .= ", ";
					$i++;
				}

				$out .= ")";

				if($j < count($rows))
				{
					$out .= ",";
				}else{
					$out .= ";";
				}
				$j++;
			}
		}

		return $out;		
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

				try
				{
					DB::query($sql)->execute();					
				}catch(Fuel\Core\Database_Exception $e)
				{
					$e = (strlen($e) > 1000) ? substr($e,0,400) : $e;
					Session::set_flash('error', 'There was an error restoring the database, please copy the following error an report/email it to the developer: '.$e);				
				}
			}

			Session::set_flash('success', 'The backup file has been succesfully restored.');				

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
