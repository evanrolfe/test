<?php
use Orm\Model;

class Model_Image extends Model
{
	protected static $_properties = array(
		'id',
		'belongs_to_id',
		'belongs_to',
		'url',
		'type',
		'created_at',
		'updated_at',
		'public_image',
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


	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('boat_id', 'Boat Id', 'required');

		return $val;
	}

	public function ext()
	{
		$url_arr = explode(".", $this->url);
		return strtolower($url_arr[1]);
	}
}
