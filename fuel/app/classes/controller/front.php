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
			array('Newest', 'created_at', 'grey'),
			array('Price', 'price', 'grey'),
			array('LOA', 'length', 'grey'),
			array('Share Size', 'share_size', 'grey'),				
		);

		$loc_specific = Model_Formfieldbuyer::find('first', array('where'=>array('tag'=>'location_specific','belongs_to'=>'seller')));
		$loc_general = Model_Formfieldbuyer::find('first', array('where'=>array('tag'=>'location_general','belongs_to'=>'seller')));


		switch($this->param('sort_col'))
		{
			case 'created_at':
				$order = array('created_at'=>'DESC');
				$data['sort_options'][0][2]='red';
			break;

			case 'price':
				$order = array('price'=>'ASC');
				$data['sort_options'][1][2]='red';
			break;

			case 'length':
				$order = array('length'=>'ASC');
				$data['sort_options'][2][2]='red';
			break;

			case 'share_size':
				$order = array('share_size'=>'DESC');
				$data['sort_options'][3][2]='red';
			break;

			default:
				$order = array('created_at'=>'DESC');
				$data['sort_options'][0][2]='red';					
		}

		$form_action_url = 'front/sort_by'.$this->param('sort_col');


		if(Input::method()=='POST')
		{
			//Is the location general or specific?
			$loc_col = (in_array(Input::post('location'), $loc_general->options)) ? 'location_general' : 'location_specific';

			$data['yachtshares'] = Model_Yachtshare::find('all', array(
				'where' => array('approved'=>1, 'active'=>1, $loc_col =>Input::post('location')),
				'order_by' => $order,
				));
		}else{
			$data['yachtshares'] = Model_Yachtshare::find('all', array(
				'where' => array('approved'=>1, 'active'=>1),
				'order_by' => $order,
			));
		}

		//$data['locations'] = array();
		$data['locations'] = $loc_general->options; //array_merge($loc_general->options, $loc_specific->options);
		$data['selected_location'] = Input::post('location');

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

		$this->template->content = View::forge('front/view',$data);
	}
}