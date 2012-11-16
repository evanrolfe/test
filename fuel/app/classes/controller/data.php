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
		$columns = DB::list_columns('yachtshares');		

    	foreach($columns as $col)
		{
			 switch($col['data_type'])
			{
				case "int":
					$constraint = $col['display'];
				break;

				case "varchar":
					$constraint = $col['character_maximum_length'];
				break;
	
				default:
					$constraint = null;
			}

			echo $col['name'].", type: ".$col['data_type'].", constraint: ".$constraint."<br>";
		}

		echo "<pre>";
		print_r($columns);
		echo "</pre>";

		exit;
	}

	public function action_export()
	{	
		$date = Date::forge()->format("%d-%m-%Y %H:%m");

		$backup = Model_Backup::forge(array(
			'note' =>'',
			'type' => 'export',
		));

		$backup->save();
		$filename = "backup.sql";
		File::update(DOCROOT, $filename, $this->get_sql_string());
		Response::redirect(Uri::create('public/'.$filename));
	}

	public function action_export_old()
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
		$tables = array('actionsteps','asnames','buyers','emailtemplates','formfields_buyer','images','yachtshares');

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
					DBUtil::set_connection('unlocked');
					DB::query($sql)->execute();
					DBUtil::set_connection(null);
					
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


//==========================================================================================
// HTML SCRAPER FUNCTIONS/AND
//==========================================================================================
	public function action_missing_images()
	{
		$images = Model_Image::find('all');

		foreach ($images as $image)
		{
			$exists = file_exists(DOCROOT.'uploads/'.$image->url) ? '<font color="green">exists</font>' : '<font color="red">Does not exist</font> - (<a href="'.Uri::create('yachtshare/view/'.$image->belongs_to_id).'">Yacht</a>';

			echo 'Image_ID: '.$image->id.'; filename: '.$image->url."\t\t".$exists."<br>";
		}

		exit;
	}

	public function action_scrap()
	{
		//$this->import_from_yachtfractions("http://www.yachtfractions.co.uk/OS/sail.asp","Sailing boat shares overseas","Mediterranean", "Greece");
		$this->import_from_yachtfractions("http://www.yachtfractions.co.uk/UK/sail.asp","Sailing boat shares UK","UK", "UK: south coast");
		//$this->import_from_yachtfractions("http://www.yachtfractions.co.uk/MY/sail.asp","Motor boat shares UK","UK", "UK: south coast");
		exit;
	}

	public function import_from_inactive()
	{
		 $ch = curl_init();
		 curl_setopt($ch, CURLOPT_URL, $url);
		 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		 $contents = curl_exec ($ch);
		 curl_close ($ch);

		$doc = new DOMDocument();
		@$doc->loadHTML($contents);

		$urls = array();
		$links = $doc->getElementsByTagName("a");

		foreach($links as $link)
		{
			$href = $link->attributes->getNamedItem('href')->nodeValue;

			//if(preg_match())
		}
	}


	public function import_from_yachtfractions($url,$type,$loc_general,$loc_specific)
	{
		 $ch = curl_init();
		 curl_setopt($ch, CURLOPT_URL, $url);
		 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		 $contents = curl_exec ($ch);
		 curl_close ($ch);

		$doc = new DOMDocument();
		@$doc->loadHTML($contents);

		$urls = array();
		$links = $doc->getElementsByTagName("a");

		foreach($links as $link)
		{
			$parsed_url = explode("=",$link->attributes->getNamedItem('href')->nodeValue);
			($link->nodeValue == "More details...") and $urls[] = $parsed_url[1];
		}

		foreach($urls as $id)
		{
			echo "<a href='http://www.yachtfractions.co.uk/UK/detail.asp?ID=".$id."'>http://www.yachtfractions.co.uk/UK/detail.asp?ID=".$id."</a>";
			$boat = $this->get_data_for_id($id);
			echo "<pre>";
			print_r($boat);
			echo "</pre>";

			$all_yachtshares = Model_Yachtshare::find('all');

			$found_yachtshares = Search::find($boat['name'])
				->in($all_yachtshares) // the data to search through
				->by('name', 'make') // the fields you wan't to search through
				->execute();

			echo "Num of matched yachtshares: ".sizeof($found_yachtshares);
			echo "<hr>";
		}
		exit;
/*
		$str ="";
		foreach($urls as $id)
		{
			$boat = $this->get_data_for_id($id);


			$name = $boat['name'];
			$images = $boat['images'];
			$price = $boat['price'];
			$length = $boat['length'];
			$share_size = $boat['share_size'];
			unset($boat['name']);
			unset($boat['images']);
			unset($boat['length']);
			unset($boat['price']);
			unset($boat['share_size']);
			$details = json_encode($boat);
*/
			//Convert share size fration to floating point number
			//$share_size_arr = explode("/", $share_size);
			//$share_size = (float) $share_size_arr[0]/$share_size_arr[1];
/*
			if(is_null($share_size_arr[0]) || is_null($share_size_arr[1]))
			{
					echo "\tCould not save boat with name: ".$boat->db->name;
					continue;
			}
*/
/*
				$boat_db = Model_YachtShare::forge(array(
					'name' 			=> $name,
					'type' 			=> $type,
					'location_general' => $loc_general,
					'location_specific' => $loc_specific,
					'length' => $length,
					'price' => $price,
					//'share_size' => $share_size,
					//'share_size_num' => $share_size_arr[0],
					//'share_size_den' => $share_size_arr[1],
					'location' 		=> 	$boat['lying'],
					'boat_details' 	=> 	$details,
					'active'		=> 1,
				));

			$str .= $boat_db->name." (".$boat_db->make.") | ".$price." has images called: ";
			foreach($images as $url)
			{
				$parsed_url = explode("/", $url);
				$filename = str_replace(" ", '_', array_pop($parsed_url));

				$exists = file_exists(DOCROOT.'uploads/'.$filename) ? 'exists' : '<font color="red">Does not exist</font>';
				$str .= "<br>------->".$filename;
			}
			$str.= "<hr>";
*/
/*			
			if(!$boat_db->save())
			{
					echo "\tCould not save boat with name: ".$boat->db->name;
					continue;
			}

			foreach($images as $url)
			{
				$this->insert_image($url, $boat_db->id);		
			}
*/
			//echo $str;
		//}


	}

	//================================================
	//IMPORTANT: to use php's copy() function,
	//allow_url_fopen must be set as on in php.ini!!!
	//================================================
	protected static function insert_image($url, $boat_id)
	{
		$parsed_url = explode("/", $url);
		$url = str_replace(" ", "%20", $url);
		$filename = str_replace(" ", '_', array_pop($parsed_url));

		if(!file_exists("uploads/".$filename))
			copy($url, "uploads/".$filename);

		$image = Model_Image::forge(array(
			'belongs_to_id' => $boat_id,
			'belongs_to' => 'yachtshare',
			'public_image' => 1,
			'url' => $filename,
		));

		$image->save();
	}

	public static function get_data_for_id($id)
	{
		 $ch = curl_init();

		 curl_setopt($ch, CURLOPT_URL, "http://www.yachtfractions.co.uk/UK/detail.asp?ID=".$id);


		 curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		 $contents = curl_exec ($ch);

		 curl_close ($ch);

		$doc = new DOMDocument();
		@$doc->loadHTML($contents);
		//echo $doc->saveHTML();

		$data = array();

		//1. Get the NAME
		//-----------------------
		$hs = $doc->getElementsByTagName("h1");
		$children = $hs->item(0)->childNodes; 
		$innerHTML = "";
		foreach ($children as $child) { 
		    $innerHTML .= @$child->ownerDocument->saveXML( $child ); 
		} 

		$data['name'] = $innerHTML; 

		//2. Get the IMAGES
		//-----------------------
		$imgs = $doc->getElementsByTagName("img");
		$children = $hs->item(0)->childNodes; 
		$data['images'] = array();
		foreach ($imgs as $img) { 
			$data['images'][] = "http://www.yachtfractions.co.uk".(substr($img->attributes->getNamedItem('src')->nodeValue, 2));
		} 
/*

		//3. Get the UL/LI ELEMENTS
		//--------------------------
		$lists = $doc->getElementsByTagName("ul");

		$i=0;
		foreach($lists as $ul){
			//echo $i.") ".$ul->nodeValue."<hr>";
	
			switch($i)
			{
				case 0:
					$key = "equipment";
				break;

				case 1:
					$key = "engine";
				break;

				case 2:
					$key = "navigation";
				break;

				case 3:
					$key = "accomodation";
				break;

				case 4:
					$key = "dinghy";
				break;

				case 5:
					$key = "owners_comments";
				break;

				case 6:
					$key = "annual_costs";
				break;
			}

			$data[$key] = $ul->nodeValue;
			$i++;
		}

		//4. Get the TABLE ELEMENTS
		//--------------------------
		$cells = $doc->getElementsByTagName("td");

		$i=0;

		foreach($cells as $td){
			//echo $i.") ".$td->nodeValue->nodeValue."<hr>";

			switch($i)
			{
				case 2:
					$data['length'] = substr($td->nodeValue,0,-3);
				break;

				case 5:
					$data['lwl'] = $td->nodeValue;
				break;

				case 8:
					$data['beam'] = $td->nodeValue;
				break;

				case 11:
					$data['draft'] = $td->nodeValue;
				break;

				case 14:
					$data['keel'] = $td->nodeValue;
				break;

				case 17:
					$data['built'] = $td->nodeValue;
				break;

				case 20:
					$data['lying'] = $td->nodeValue;
				break;

				case 25:
					$price_arr = explode(" ", $td->nodeValue);
					$data['price'] = substr($price_arr[0],2);
				break;

				case 28:
					$data['share_size'] = $td->nodeValue;
				break;
			}
			$i++;
		}
*/
		return $data;
	}
}
