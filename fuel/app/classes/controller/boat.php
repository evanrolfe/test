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

	public function import($url,$type,$loc_general,$loc_specific)
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

		foreach($links as $link){
			$parsed_url = explode("=",$link->attributes->getNamedItem('href')->nodeValue);
			($link->nodeValue == "More details...") and $urls[] = $parsed_url[1];
		}

		$data = array();
		foreach($urls as $id){
			$data[] = $this->get_data_for_id($id);
		}

		foreach($data as $boat)
		{
			echo "Saving boat name: ".$boat_db->name."<br>";

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

		//Convert share size fration to floating point number
		$share_size_arr = explode("/", $share_size);
		$share_size = (float) $share_size_arr[0]/$share_size_arr[1];

		if(is_null($share_size_arr[0]) || is_null($share_size_arr[1]))
		{
				echo "\tCould not save boat with name: ".$boat->db->name;
				continue;
		}
			$boat_db = Model_YachtShare::forge(array(
				'name' 			=> $name,
				'type' 			=> $type,
				'location_general' => $loc_general,
				'location_specific' => $loc_specific,
				'length' => $length,
				'price' => $price,
				'share_size' => $share_size,
				'share_size_num' => $share_size_arr[0],
				'share_size_den' => $share_size_arr[1],
				'location' 		=> 	$boat['lying'],
				'boat_details' 	=> 	$details,
				'active'		=> 1,
			));

			
		if(!$boat_db->save())
		{
				echo "\tCould not save boat with name: ".$boat->db->name;
				continue;
		}

			foreach($images as $url){
				$this->insert_image($url, $boat_db->id);		
			}
		}
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
			$data['images'][] = "http://www.yachtfractions.co.uk/".(substr($img->attributes->getNamedItem('src')->nodeValue, 2));
		} 


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

		return $data;
	}
}
