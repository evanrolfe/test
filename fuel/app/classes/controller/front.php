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

	public function action_index($all = null)
	{
		//Find the yachtshares according to any user defined filter preferences
		$data['yachtshares'] = Model_Yachtshare::find('all', array('where' => array('approved'=>1, 'active'=>1)));
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