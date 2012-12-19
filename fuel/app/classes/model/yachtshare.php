<?php

class Model_Yachtshare extends \Orm\Model
{
	protected static $_belongs_to = array(
		'seller' => array(
		    'key_from' => 'user_id',
		    'model_to' => 'Model_User',
		    'key_to' => 'id',
		    'cascade_save' => true,
		    'cascade_delete' => false,
		)
	);

	protected static $_has_many = array(
		'actionsteps' => array(
		    'key_from' => 'id',
		    'model_to' => 'Model_Actionstep',
		    'key_to' => 'boat_share_id',
		    'cascade_save' => true,
		    'cascade_delete' => true,
		)
	);

	protected static $_properties = array(
		'id',
		'name',
		'make',
		'type',
		'location_general',
		'location_specific',
		'length',
		'price',
		'share_size',
		'share_size_num',
		'share_size_den',
		'boat_details',
		'user_id',
		'created_at',
		'updated_at',
		'active',
		'temp',
		'reminder',
		'reminder_expires_at',
		'approved',
		'group_ids',
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
		'Orm\\Observer_Self' => array(
			'before_insert'
		),
	);

	public function _event_before_insert()
	{	
		$this->approved = 0;
	}

	public function __construct(array $data = array(), $new = true, $view = null)
	{
		parent::__construct($data, $new, $view);

		if($new == false)
		{
			$fields = json_decode($this->boat_details, true);
			//$fields = (str_replace("\n", "<br>", $fields));
			$this->boat_details = ($fields) ? $fields : array();

			$this->share_size = round($this->share_size,3);
			$this->boat_details['share_size_fraction'] = $this->share_size_num.'/'.$this->share_size_den;
		}
	}

	public function details($filter = false)
	{
		return array();//json_decode($this->boat_details, true);

		//$filter or $fields = (str_replace("\n", "<br>", $fields));
		//return ($fields) ? $fields : array();
	}

/**
* Fetch all yachtshares which are on hold along with the hours left until the hold expires
*
* @return array
*/
	public static function find_on_hold()
	{
		$query = DB::query('SELECT actionsteps.id as actionstep_id, actionsteps.email_sent, actionsteps.buyer_id AS buyer_id, yachtshares.id, yachtshares.name AS yachtshare_name, buyers.name AS buyer_name, ROUND((expires_at-UNIX_TIMESTAMP(NOW()))/3600,1) AS hours_left FROM `actionsteps` LEFT JOIN `yachtshares` ON (yachtshares.id=boat_share_id) LEFT JOIN `buyers` ON (buyers.id=actionsteps.buyer_id) WHERE expires_at > UNIX_TIMESTAMP(NOW())');
		return $query->as_object()->execute();
	}

/**
* Fetch all yachtshares which have a reminder active
*
* @return array
*/
	public static function find_with_active_reminder()
	{
		$query = DB::query('SELECT * FROM `yachtshares` WHERE reminder_expires_at < UNIX_TIMESTAMP(NOW()) AND reminder_expires_at > 0');
		return $query->as_object()->execute();
	}

/**
* Fetch all yachtshares which are pending the approval of the admin
*
* @return array
*/
	public static function find_with_pending_approval()
	{
		$query = DB::query('SELECT * FROM `yachtshares` WHERE approved=0');
		return $query->as_object()->execute();
	}	

/**
* Find actionsteps that have still not been added to this yachtshare
*
* @return array
*/
	public function available_actionsteps(){
		$query = DB::query('SELECT * FROM `asnames` WHERE id NOT IN (SELECT asnames.id FROM `actionsteps` LEFT JOIN `asnames` ON (asnames.id=actionstep_set_id) WHERE boat_share_id='.$this->id.' AND buyer_id NOT IN (SELECT buyer_id FROM `actionsteps` WHERE actionstep_set_id=11 AND boat_share_id='.$this->id.' GROUP BY buyer_id)) ORDER BY asnames.order ASC');

		return $query->as_object()->execute();
	}

/**
* Determine whether or not this yachtshare is on hold for somebody
*
* @return boolean
*/
	public function is_onhold()
	{
		$query = DB::query('SELECT * FROM `actionsteps` WHERE boat_share_id='.$this->id.' AND expires_at > UNIX_TIMESTAMP(NOW())');
		$num = count($query->execute());

		return ($num > 0) ? true : false;
	}

/**
* Find the timestamp at which this will expire
*
* @return integer the timestamp
*/
	public function get_hold_actionstep()
	{
		$res = DB::query('SELECT * FROM `actionsteps` WHERE boat_share_id='.$this->id.' AND expires_at > UNIX_TIMESTAMP(NOW())')->execute();
		return $res[0];
	}

/**
* Determine whether or not this yachtshare has already been sold
*
* @return boolean
*/
	public function is_sold()
	{
		$query = DB::query('SELECT * FROM `actionsteps` WHERE boat_share_id='.$this->id.' AND type="complete"');
		$num = count($query->execute());

		return ($num > 0) ? true : false;
	}

	public function sold_to()
	{
		$query = DB::query('SELECT buyer_id FROM `actionsteps` WHERE boat_share_id='.$this->id.' AND type="complete"');
		$result = $query->execute();
		return $result;
	}

/**
* Find the number of buyers that this yachtshare has been introduced to
*
* @return integer
*/
	public function num_introductions()
	{
		$query = DB::query('SELECT * FROM `actionsteps` WHERE boat_share_id='.$this->id.' AND (type="introduction" OR actionstep_set_id=1)');
		return count($query->as_object()->execute());	
	}

/**
* Determine whether or not this yachtshare has already been introduced to a certain buyer
*
* @return boolean
*/
	public function already_introduced_to_buyer($buyer_id)
	{
		$query = DB::query('SELECT * FROM `actionsteps` WHERE boat_share_id='.$this->id.' AND buyer_id='.$buyer_id.' AND (type="introduction" OR actionstep_set_id=1)');
		$num = count($query->as_object()->execute());	
		return ($num > 0) ? true : false;
	}

/**
* Return the date of the last actionstep that is associated with this yachtshare
*
* @return string
*/
	public function date_last_activity()
	{
		$query = DB::query('SELECT max(occurred_at) AS occurred_at FROM `actionsteps` WHERE boat_share_id='.$this->id.' AND actionstep_set_id = 1');
		$arr = $query->as_assoc()->execute();	
		return ($arr[0]['occurred_at']) ? Date::forge($arr[0]['occurred_at'])->format("%d/%m/%Y") : "";
	}

/**
* Find the buyers that are linked to this boat through actionsteps
* return an array of buyers with their details and 
* each buyer has an array of actionsteps
*
* If $active is true then only return the buyers who have actionsteps with this yachtshare beyond an introduction
*
* Used in yachtshare/view/*
*
* @return array
*/
	public function buyers($active = false)
	{
		$active = ($active) ? 'AND type="action"' : "";
		$query = DB::query('SELECT * FROM `buyers` WHERE id IN (SELECT buyer_id FROM `actionsteps` WHERE boat_share_id='.$this->id.' '.$active.' GROUP BY buyer_id)');

		$buyers = $query->as_object()->execute();

		foreach($buyers as $buyer)
		{
			$query = DB::query('SELECT * FROM `actionsteps` WHERE buyer_id='.$buyer->id.' AND boat_share_id='.$this->id.' '.$active.' ORDER BY created_at ASC');

			$buyer->actionsteps = $query->as_object()->execute();
		}

		return $buyers;
	}

/**
* Status of this particular yachtshare
*
* @return string can be one of "Available", "Sale in progress", "On hold", "Sold"
*/
	public function status()
	{
		if($this->active == 0)
		{
			return "Deactivated";
		}elseif($this->is_sold()){
			return "Sold";
		}elseif((count($this->buyers(true)) >0) && !$this->is_onhold()){
			return "Sale in progress";
		}elseif($this->is_onhold()){
			return "On hold";
		}elseif($this->temp == true){
			return "Temporarily Saved Form";
		}else{
			return "Available";
		}
	}
}
