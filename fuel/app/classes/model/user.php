<?php

class Model_User extends \Orm\Model
{
	protected static $_properties = array(
		'id',
		'email',
		'name',
		'type',
		'password',
		'salt',
		'created_at',
		'updated_at',
		'selected_yacht_cols',
		'selected_buyer_cols'
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
		$val->add_field('email', 'Email', 'unique');

		return $val;
	}
}
