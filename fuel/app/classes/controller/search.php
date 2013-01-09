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
			array('Newest', 'created_at', 'grey',''),
			array('Price', 'price', 'grey',''),
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
			switch($this->param('type'))
			{
				case "sail":
					$where_from_url = array('type', 'IN', array("Sailing boat shares UK","Sailing boat shares overseas"));					
				break;

				case "motor":
					$where_from_url = array('type', 'IN', array("Motor boat shares UK","Motor boat shares O/S"));
				break;

				case "brokerage":
					$where_from_url = array('type','=',"Used Yacht on brokerage");
				break;
			}
		}		

		if(Input::method()=='POST')
		{
			$where = array(array('approved','=',1), array('active','=',1));

			//if(count($where_from_url) > 0)
				//$where[] = $where_from_url;

			//LOCATION OPTIONS:
			if(Input::post('filter_location'))
			{
				//Is the location general or specific?
				$loc_col = (in_array(Input::post('filter_location'), $loc_general->options)) ? 'location_general' : 'location_specific';

				$where[] = array($loc_col, '=', Input::post('filter_location'));
			}


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
				$data['sort_options'][0][2]='red';
				$data['sort_options'][0][3]='1';				
			}elseif(Input::post('price'))
			{
				$order = array('price'=>'ASC');
				$data['sort_options'][1][2]='red';
				$data['sort_options'][1][3]='1';				
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
				$order = array('created_at'=>'DESC');
				$data['sort_options'][0][2]='red';
				$data['form_action_url'] = 'front';									
			}			

			//echo "WHERE:<br>";
			//echo "<pre>";
			//print_r(Input::post());
			//print_r($where);
			//echo "</pre><br>ORDER:<br><pre>";
			//print_r($order);
			//exit;

			$data['yachtshares'] = Model_Yachtshare::find('all', array(
				'where' => $where,
				'order_by' => $order,
				));
		}else{
			//Sort by newest as defualt:
			$data['sort_options'][0][2]='red';
			$data['form_action_url'] = 'front';	

			$where = array(array('approved','=',1), array('active','=',1));

			if(count($where_from_url) > 0)
				$where[] = $where_from_url;

			$data['yachtshares'] = Model_Yachtshare::find('all', array(
				'where' => $where,
				'order_by' => array('created_at'=>'DESC'),
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