<?php
/*
 * RULES:
 * Order = 1 means that this is the first step to be completed
 * Order = 0 means that this actionstep will cancel the sale progress
 */
use Orm\Model;

class Model_Asname extends Model
{
	protected static $_properties = array(
		'id',
		'title',
		'options',
		'order',
		'created_at',
		'updated_at'
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
}
