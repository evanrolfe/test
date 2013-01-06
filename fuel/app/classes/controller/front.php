<?php
//ALTER TABLE  `yachtshares` ADD  `approved` BOOLEAN NULL DEFAULT  '0'
class Controller_Front extends MyController
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


		if(Input::method()=='POST')
		{
		
			$where = array(array('approved','=',1), array('active','=',1));
			//LOCATION OPTIONS:
			if(Input::post('location'))	
			{	
				//Is the location general or specific?
				$loc_col = (in_array(Input::post('location'), $loc_general->options)) ? 'location_general' : 'location_specific';

				$where[] = array($loc_col, '=', Input::post('location'));
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

/*
			echo "WHERE:<br>";
			echo "<pre>";
			print_r($where);
			echo "</pre><br>ORDER:<br><pre>";
			print_r($order);
			exit;
*/
			$data['yachtshares'] = Model_Yachtshare::find('all', array(
				'where' => $where,
				'order_by' => $order,
				));
		}else{
			//Sort by newest as defualt:
			$data['sort_options'][0][2]='red';
			$data['form_action_url'] = 'front';									
			$where = array('approved'=>1, 'active'=>1);

			$data['yachtshares'] = Model_Yachtshare::find('all', array(
				'where' => $where,
				'order_by' => array('created_at'=>'DESC'),
			));
		}

		//$data['locations'] = array();
		$data['locations'] = array_merge($loc_general->options, $loc_specific->options);

		$data['types'] = array("Sailing Yacht Shares","Motor Yacht Shares", "Brokerage");

		$data['selected_type'] = Input::post('type');		
		$data['selected_location'] = Input::post('location');

		//Find the id of the first five newest yachtshares
		$yachtshares_sorted_by_newest = Model_Yachtshare::find('all', array(
			'where' => $where,
			'order_by' => array('created_at'=>'DESC'),
		));

		$data['newest_ids'] = array();
		$i=0;
		if(count($yachtshares_sorted_by_newest) > 5)
		{
			foreach($yachtshares_sorted_by_newest as $yachtshare)
			{
				if($i<5)
					$data['newest_ids'][] = $yachtshare->id;

				$i++;
			}
		}

		//Find the yachtshares according to any user defined filter preferences
		$this->template->content = View::forge('front/index',$data);
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
}