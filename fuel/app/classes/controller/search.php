<?php
//ALTER TABLE  `yachtshares` ADD  `approved` BOOLEAN NULL DEFAULT  '0'
class Controller_Search extends MyController
{
	public function before()
	{
		parent::before();
		$this->template = \View::forge('front_end_template',array(),false);
		//$this->template->content = View::forge('session/login');
	}

	//Route structure
	//'front/list/loc/:location/type/:type/sort/:sort' => 'front/index'
	//Default (display all) route:
	///front/list/loc/-/type/-/sort/-

	public function action_index()
	{
		$data['sort_options'] = array(
			array('Price', 'price', 'grey',''),			
			array('Newest', 'created_at', 'grey',''),
			array('LOA', 'length', 'grey',''),
			array('Share Size', 'share_size', 'grey',''),
			array('Location', 'location_specific', 'grey',''),							
		);

		$loc_specific = Model_Formfieldbuyer::find('first', array('where'=>array('tag'=>'location_specific','belongs_to'=>'seller')));
		$loc_general = Model_Formfieldbuyer::find('first', array('where'=>array('tag'=>'location_general','belongs_to'=>'seller')));

		//TYPE FILTERING FROM URL
		$where_from_url = array();
		if($this->param('type'))
		{
			$data['locations'] = array();
			$data['type_url'] = $this->param('type');

			switch($this->param('type'))
			{
				case "uk_yachts":
					$where_from_url = array('type', '=', "Sailing boat shares UK");
					$data['heading'] = "Sailing boat shares UK";

					//Only show the UK specific locations
					foreach($loc_specific->options as $loc)
					{
						if(substr($loc, 0,3) == "UK:")
							$data['locations'][] = $loc;
					}
				break;

				case "overseas_yachts":
					$where_from_url = array('type', '=', "Sailing boat shares overseas");
					$data['heading'] = "Sailing boat shares overseas";

					//List ALL general locations EXCEPT "UK"
					foreach($loc_general->options as $loc)
					{
						if(substr($loc, 0,2) != "UK")
							$data['locations'][] = $loc;
					}								
				break;

				case "motor":
					$where_from_url = array('type', 'LIKE', "%Motor%");
					$data['heading'] = "Motor boat shares";
					$data['locations'] = $loc_general->options;
				break;

				case "brokerages":
					$where_from_url = array('type', 'LIKE', "%brokerage%");
					$data['heading'] = "Brokerages";
					$data['locations'] = $loc_general->options;															
				break;

				default:
					throw new HttpNotFoundException;									
			}

			echo "<pre>";
			print_r($where_from_url);
			echo "</pre>";
		}		

		if(Input::method()=='POST')
		{
			//echo "<pre>";
			//print_r(Input::post());
			//echo "</pre>";
			$where = array(array('approved','=',1), array('active','=',1));


			//LOCATION OPTIONS:
			if(Input::post('filter_location'))
			{
				//Is the location general or specific?
				$loc_col = (in_array(Input::post('filter_location'), $loc_general->options)) ? 'location_general' : 'location_specific';

				$where[] = array($loc_col, '=', Input::post('filter_location'));
			}

			if($this->param('type'))
				$where[] = $where_from_url;


			//TYPE OPTIONS
			if(Input::post('type'))
			{
				$type = Input::post('type');

				switch(Input::post('type'))
				{
					case "Sailing Yacht Shares":
						$where[] = array('type', 'IN', array("Sailing boat shares UK","Sailing boat shares overseas"));					
					break;

					case "Motor Yacht Shares":
						$where[] = array('type', 'IN', array("Motor boat shares UK","Motor boat shares O/S"));
					break;

					case "Brokerage":
						$where[] = array('type','=',"Used Yacht on brokerage");
					break;
				}
			}

			//PRICE OPTIONS
			if(Input::post('filter_price'))
			{
				switch(Input::post('filter_price'))
				{
					case "less than £10,000":
						$where[] = array('price', '<', 10000);					
					break;

					case "£10,000 - £20,000":
						$where[] = array('price', '>', 10000);	
						$where[] = array('price', '<', 20000);										
					break;

					case "£20,000 - £30,000":
						$where[] = array('price', '>', 20000);	
						$where[] = array('price', '<', 30000);					
					break;

					case "greater than £30,000":
						$where[] = array('price', '>', 30000);						
					break;
				}
			}
			//ORDER OPTIONS
			if(Input::post('created_at'))
			{
				$order = array('created_at'=>'DESC');
				$data['sort_options'][1][2]='red';
				$data['sort_options'][1][3]='1';				
			}elseif(Input::post('price'))
			{
				$order = array('price'=>'ASC');
				$data['sort_options'][0][2]='red';
				$data['sort_options'][0][3]='1';				
			}elseif(Input::post('length'))
			{
				$order = array('length'=>'ASC');
				$data['sort_options'][2][2]='red';
				$data['sort_options'][2][3]='1';
			}elseif(Input::post('share_size'))				
			{
				$order = array('share_size'=>'DESC');
				$data['sort_options'][3][2]='red';
				$data['sort_options'][3][3]='1';
			}elseif(Input::post('location_specific'))				
			{
				$order = array('location_specific'=>'ASC');
				$data['sort_options'][4][2]='red';
				$data['sort_options'][4][3]='1';
			}else{
				$order = array('price'=>'ASC');
				$data['sort_options'][0][2]='red';
				$data['sort_options'][0][3]='1';				
			}			

			$params = array(
				'where' => $where,
				'order_by' => $order,
			);

			//TODO:
			if(!Input::post('show_all'))
			{
				$params['limit'] = 15;
				$data['show_all'] = '';				
			}else{
				$data['show_all'] = 1;
			}

			$data['yachtshares'] = Model_Yachtshare::find('all', $params);
		}else{
			//Sort by newest as defualt:
			$data['sort_options'][0][2]='red';
			$data['form_action_url'] = 'front';	

			$data['show_all'] = '';
			
			$where = array(array('approved','=',1), array('active','=',1));

			if(count($where_from_url) > 0)
				$where[] = $where_from_url;

			$data['yachtshares'] = Model_Yachtshare::find('all', array(
				'where' => $where,
				'order_by' => array('price'=>'ASC'),
				'limit' => 15,
			));
		}

		//$data['locations'] = array();
		$data['loc_general'] = $loc_general->options;
		$data['loc_specific'] = $loc_specific->options;
		$data['types'] = array("Sailing Yacht Shares", "Motor Yacht Shares", "Brokerage");
		$data['prices'] = array("less than £10,000", "£10,000 - £20,000", "£20,000 - £30,000", "greater than £30,000");

		$data['selected_type'] = Input::post('type');		
		$data['selected_location'] = Input::post('filter_location');
		$data['selected_price'] = Input::post('filter_price');		

		$data['path'] = DOCROOT;

		//Find the yachtshares according to any user defined filter preferences
		$this->template->content = View::forge('front/index',$data, false);
	}

	public function action_yachtshare($id = null)
	{
		if(is_null($id))
			throw new HttpNotFoundException;

		$data['yachtshare'] = Model_Yachtshare::find($id);

		if(!$data['yachtshare'])
			throw new HttpNotFoundException;

		$this->template->content = View::forge('front/view',$data,false);
	}

	public function action_images($id = null)
	{
		if(is_null($id))
			throw new HttpNotFoundException;

		$data['yachtshare'] = Model_Yachtshare::find($id);

		if(!$data['yachtshare'])
			throw new HttpNotFoundException;

		$this->template->content = View::forge('front/images',$data,false);
	}	
}