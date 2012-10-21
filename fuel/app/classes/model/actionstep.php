<?php
use Orm\Model;

class Model_Actionstep extends Model
{
	protected static $_properties = array(
		'id',
		'title',
		'type',
		'note',
		'boat_share_id',
		'buyer_id',
	//Store hold as the timestamp at which the hold shall expire
	//If no hold is needed then set the hold = created_at
		'hold',	
		'occurred_at',
		'actionstep_set_id',
		'expires_at',
		'created_at',
		'updated_at',
		'email_sent',
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

		if($new == false)
		{
			$hours = $this->hold;
			
			$this->hold = ($fields) ? $fields : array();
		}
	}


	public static function validate($factory)
	{
		$val = Validation::forge($factory);
		$val->add_field('title', 'Title', 'max_length[255]');
		//$val->add_field('note', 'Note', '');
		$val->add_field('boat_share_id', 'Boat Share Id', 'required');
		$val->add_field('buyer_id', 'Buyer Id', 'required');

		return $val;
	}

	//Return true if this actionstep is for a buyer and share that is still in progress (i.e. the buyer has not declined)
	public function active(){
		return !($this->find()->where(array('buyer_id' => $this->buyer_id, 'boat_share_id' => $this->boat_share_id, 'title' => 'Declined'))->count() > 0);
	}

	//Fetch actionsteps which with a lower order than this one which have not been added to the boat share
	public function previous_active_ones(){
		$query = DB::query("SELECT * FROM `asnames`
WHERE asnames.order NOT IN (0) 
AND asnames.order < (SELECT asnames.order FROM `asnames` WHERE id=".$this->actionstep_set_id.") 
AND asnames.order > (SELECT max(asnames.order) FROM `actionsteps` LEFT JOIN `asnames` ON (asnames.id=actionstep_set_id) WHERE boat_share_id=".$this->boat_share_id." AND buyer_id=".$this->buyer_id.")");

		return $query->as_object()->execute();
	}

	//Find actionsteps which are available to a particular buyer and yachtshare
	public static function available($buyer_id, $yachtshare_id)
	{
		$query = DB::query('SELECT * FROM `asnames` WHERE ID NOT IN (SELECT actionstep_set_id FROM `actionsteps` WHERE boat_share_id='.$yachtshare_id.' AND buyer_id='.$buyer_id.')');

		return $query->as_object()->execute();
	}

	public static function cancel($buyer_id, $yachtshare_id, $type)
	{
		$query = DB::query("UPDATE `actionsteps` SET type='".$type."' WHERE boat_share_id=".$yachtshare_id." AND buyer_id=".$buyer_id);
		$query->execute();
	}
}
