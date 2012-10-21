<?php
class MyTemplate
{
	protected $view_path;
	protected $data = array();

	public static function hello(){
		return "WORLD";
	}

	public function after($response)
	{
		$this->template->content = View::forge($this->view_path, $this->data);
	}
}
