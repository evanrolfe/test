<?php
use Orm\Model;

class Model_Boat extends Model
{
	//RELATIONS
	protected static $_has_many = array('shares', 'images'); 

	protected static $_properties = array(
		'id',
		'name',
		'location',
		'location_specific',
		'location_general',
		'description',
		'length',
		'created_at',
		'updated_at',
	);

	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
			'mysql_timestamp' => false,
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_save'),
			'mysql_timestamp' => false,
		),
	);

	public function __construct(array $data = array(), $new = true, $view = null)
	{
		parent::__construct($data, $new, $view);
	}

	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('name', 'Name', 'required|max_length[255]');
		$val->add_field('location', 'Location', 'required|max_length[255]');
		$val->add_field('length', 'Length', 'required');

		return $val;
	}


	public function fields($filter = false)
	{
		$fields = json_decode($this->description, true);

		$filter or $fields = (str_replace("\n", "<br>", $fields));
		return ($fields) ? $fields : array();
	}
}
