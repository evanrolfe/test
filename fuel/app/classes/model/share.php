<?php
use Orm\Model;

class Model_Share extends Model
{
	//RELATIONS
	protected static $_belongs_to = array('boat');
	protected static $_has_many = array('actionsteps' => array(
		'model_to' => 'Model_Actionstep',
		'key_from' => 'id',
		'key_to' => 'boat_share_id',
		'cascade_save' => true,
		'cascade_delete' => false,
	));

	protected static $_properties = array(
		'id',
		'boat_id',
		'fraction',
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

	public static function validate($factory)
	{
		$val = Validation::forge($factory);


		return $val;
	}

	public function find_uk()
	{
		$query = DB::query('SELECT shares.fraction,boat_id,shares.id AS id, boats.location, boats.name FROM `shares` LEFT JOIN `boats` ON (shares.boat_id=boats.id) WHERE boats.location LIKE "%(UK)%"');

		return $query->as_assoc()->execute();
	}

	public function find_overseas()
	{
		$query = DB::query('SELECT shares.fraction,boat_id,shares.id AS id, boats.location, boats.name FROM `shares` LEFT JOIN `boats` ON (shares.boat_id=boats.id) WHERE boats.location NOT LIKE "%(UK)%"');

		return $query->as_object()->execute();
	}

	//Return those actionsteps which are current active
	public function active_actionsteps(){
/*
		$out = array();
		foreach($this->actionsteps as $actionstep){
			if($actionstep->active())
				$out[] = $actionstep;
		}
		return $out;
*/

		$query = DB::query("SELECT actionsteps.id,note,boat_share_id,buyer_id,actionsteps.created_at, asnames.title FROM `actionsteps` LEFT JOIN `asnames` ON (asnames.id=actionstep_set_id) WHERE boat_share_id=".$this->id." AND buyer_id NOT IN (SELECT buyer_id FROM `actionsteps` WHERE actionstep_set_id=11 AND boat_share_id=".$this->id." GROUP BY buyer_id) ORDER BY actionsteps.created_at DESC");

		return $query->as_object()->execute();
	}

	//Return the active buyer
	public function active_buyer_id(){
		//$active_actionsteps = $this->active_actionsteps();
		//return (sizeof($active_actionsteps) > 0) ? $active_actionsteps[0]->buyer_id : null;

		$query = DB::query("SELECT buyer_id FROM `actionsteps` WHERE boat_share_id=".$this->id." AND buyer_id NOT IN (SELECT buyer_id FROM `actionsteps` WHERE actionstep_set_id=11 AND boat_share_id=".$this->id." GROUP BY buyer_id) GROUP BY buyer_id");

		$object = $query->as_object()->execute();
		$output = (isset($object[0]->buyer_id)) ? $object[0]->buyer_id : 0;
		return $output;
	}

	//Return the last active actionstep
	public function last_actionstep(){
		$query = DB::query("SELECT actionsteps.id,asnames.title,actionsteps.created_at,actionsteps.options FROM `actionsteps` LEFT JOIN `asnames` ON (asnames.id=actionstep_set_id) WHERE boat_share_id=".$this->id." AND buyer_id=".$this->active_buyer_id()." ORDER BY actionsteps.created_at DESC");
		$object = $query->as_object()->execute();

		//Load the holding time (in hours) if it exists
		

		return $object[0];
	}

	//Return the actionsteps that have still not been added to this share
	public function available_actionsteps(){
		$query = DB::query('SELECT * FROM `asnames` WHERE id NOT IN (SELECT asnames.id FROM `actionsteps` LEFT JOIN `asnames` ON (asnames.id=actionstep_set_id) WHERE boat_share_id='.$this->id.' AND buyer_id NOT IN (SELECT buyer_id FROM `actionsteps` WHERE actionstep_set_id=11 AND boat_share_id='.$this->id.' GROUP BY buyer_id)) ORDER BY asnames.order ASC');

		return $query->as_object()->execute();
	}

	//Return the last active actionstep for this share
	public function last_active_actionstep(){
		$query = DB::query("SELECT note,actionsteps.created_at, asnames.title, asnames.order FROM `actionsteps` LEFT JOIN `asnames` ON (asnames.id=actionstep_set_id) WHERE boat_share_id=".$this->id." AND buyer_id NOT IN (SELECT buyer_id FROM `actionsteps` WHERE actionstep_set_id=11 AND boat_share_id=".$this->id." GROUP BY buyer_id) ORDER BY asnames.order DESC");

		return $query->as_object()->execute();
	}

	//Return true/false if the latest active actionstep shows that this share has been put on hold
	public function is_onhold(){
		return true;
	}
}
