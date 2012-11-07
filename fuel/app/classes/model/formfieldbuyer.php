<?php

class Model_Formfieldbuyer extends Exposable\Model
{
	protected static $_computed_properties = array(
		'custom',
	);

	protected static $_table_name = 'formfields_buyer';

	protected static $_properties = array(
		'id',
		'label',
		'tag',
		'type',
		'search_field',
		'order',
		'description',
		'options',
		'belongs_to',
		'validation',
		'public',
	);

	public function __construct(array $data = array(), $new = true, $view = null)
	{
		parent::__construct($data, $new, $view);

		$this->custom = "fuck yeah mother fucka";

		if($new == false)
		{
			$fields = json_decode($this->options, true);
			//$fields = (str_replace("\n", "<br>", $fields));
			$this->options = ($fields) ? $fields : array();
		}
	}

	public function are_options_linked()
	{
		return true;
	}
}
