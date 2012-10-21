<?php
use Orm\Model;

class Model_Formfieldbuyer extends Model
{
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

		if($new == false)
		{
			$fields = json_decode($this->options, true);
			//$fields = (str_replace("\n", "<br>", $fields));
			$this->options = ($fields) ? $fields : array();
		}
	}
}
