<?php
use Orm\Model;

class Model_Buyer extends Model
{
	protected static $_properties = array(
		'id',
		'name',
		'email',
		'contact',
		'preferences',
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

		if($new == false)
		{
			$fields = json_decode($this->preferences, true);
			//$fields = (str_replace("\n", "<br>", $fields));
			$this->preferences = ($fields) ? $fields : array();

			if(isset($this->preferences['boats_interest'])){
				$this->preferences['interested'] = explode(",",$this->preferences['boats_interest']);
				//unset($this->preferences['boats_interest']);
			}

			$this->preferences['max_share_size_fraction'] = $this->preferences['max_share_size_num'].'/'.$this->preferences['max_share_size_den'];
			$this->preferences['min_share_size_fraction'] = $this->preferences['min_share_size_num'].'/'.$this->preferences['min_share_size_den'];
		}
	}

	public static function validate($factory)
	{
		$val = Validation::forge($factory);

		return $val;
	}


	public function active_actionsteps()
	{
/*
		$actionsteps = Model_Actionstep::find('all', array(
			'where' => array(
				//array('boat_share_id', $this->id),
				array('buyer_id', $this->id),
				array('active', 1),
			),
			'order_by' => array('created_at' => 'ASC'),
		));
*/

		$query = DB::query("SELECT * FROM `actionsteps` WHERE buyer_id=".$this->id." AND active=1 GROUP BY boat_share_id");
		return $actionsteps;
	}

	public function actionsteps()
	{
		$query = DB::query('SELECT yachtshares.id AS yachtshare_id, yachtshares.name, actionsteps.id,actionsteps.title,actionsteps.note FROM `actionsteps` LEFT JOIN `yachtshares` ON (actionsteps.boat_share_id=yachtshares.id) WHERE buyer_id='.$this->id.' AND active=1');
		return $query->as_object()->execute();		
	}

	public function introductions()
	{
		$query = DB::query('SELECT yachtshares.id AS yachtshare_id, yachtshares.name, actionsteps.id,actionsteps.title,actionsteps.note FROM `actionsteps` LEFT JOIN `yachtshares` ON (actionsteps.boat_share_id=yachtshares.id) WHERE buyer_id='.$this->id.' AND active=1 AND actionstep_set_id=1');
		return $query->as_object()->execute();	
	}

	public function yachtshares1()
	{
		$query = DB::query('SELECT * FROM `yachtshares` WHERE id IN (SELECT boat_share_id AS yachtshare_id FROM `actionsteps` WHERE buyer_id='.$this->id.' AND active=1 GROUP BY yachtshare_id)');

		$yachtshares = $query->as_object()->execute();

		foreach($yachtshares as $yachtshare)
		{
			$query = DB::query('SELECT asnames.title, actionsteps.note, actionsteps.created_at, actionsteps.occurred_at FROM `actionsteps` LEFT JOIN `asnames` ON (asnames.id=actionsteps.actionstep_set_id) WHERE buyer_id='.$this->id.' AND boat_share_id='.$yachtshare->id.' ORDER BY created_at ASC');

			$yachtshare->actionsteps = $query = $query->as_object()->execute();
		}

		return $yachtshares;
	}

//====================================================
//====================================================
// NEW SHIT
//====================================================
//====================================================

/**
* Find the number of yachtshares that this buyer has been introduced to
*
* @return integer
*/
	public function num_introductions()
	{
		$query = DB::query('SELECT * FROM `actionsteps` WHERE buyer_id='.$this->id.' AND (type="introduction" OR actionstep_set_id=1)');
		return count($query->as_object()->execute());	
	}

/**
* Determine whether or not this buyer has already been introduced to a certain yachtshare
*
* @return boolean
*/
	public function already_introduced_to_yachtshare($yachtshare_id)
	{
		$query = DB::query('SELECT * FROM `actionsteps` WHERE boat_share_id='.$yachtshare_id.' AND buyer_id='.$this->id.' AND (type="introduction" OR actionstep_set_id=1)');
		$num = count($query->as_object()->execute());	
		return ($num > 0) ? true : false;
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
	public function yachtshares($active = false)
	{
		$active = ($active) ? 'AND type="action"' : "";
		$query = DB::query('SELECT * FROM `yachtshares` WHERE id IN (SELECT boat_share_id FROM `actionsteps` WHERE buyer_id='.$this->id.' '.$active.' GROUP BY boat_share_id)');

		$yachtshares = $query->as_object()->execute();

		foreach($yachtshares as $yachtshare)
		{
			$query = DB::query('SELECT * FROM `actionsteps` WHERE buyer_id='.$this->id.' AND boat_share_id='.$yachtshare->id.' '.$active.' ORDER BY created_at ASC');

			$yachtshare->actionsteps = $query->as_object()->execute();

			//UNIQUE TO BUYER MODEL (this is not necessary on the corresponding yachtshare function)
			$query = DB::query('SELECT * FROM `actionsteps` WHERE boat_share_id='.$yachtshare->id.' AND expires_at > UNIX_TIMESTAMP(NOW())');
			$num = count($query->execute());
			$yachtshare->onhold = ($num > 0) ? true : false;
		}

		return $yachtshares;
	}
}
