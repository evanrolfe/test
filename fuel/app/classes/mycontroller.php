<?php
class MyController extends Controller_Template 
{
	protected $view_path;
	protected $data = array();

	public function __construct(\Request $request, \Response $response)
	{
		parent::__construct($request,$response);
	}

	public function before()
	{
		parent::before();

		$this->template->links = array(
										"shares" =>	array("uri" => "yachtshare/", "name" => "Yacht Shares", "current" => false, "icon" => "icos-chart8"),
										"buyers" => 	array("uri" => "buyer/", "name" => "Buyers", "current" => false, "icon" => "icon-users"),
										"settings" =>	array("uri" => "formfieldbuyer/", "name" => "Other", "current" => false, "icon" => "icon-settings"),
										);

		$this->user = Session::get('user');

		$this->template->user = Session::get('user');

		$this->offline_config = Config::load('offline');
		$this->template->offline = $this->offline_config['offline_on?'];

		$this->offline = $this->template->offline;
		$this->content_width = $this->offline_config['content_width'];

		$this->template->yachtshares_on_hold = Model_Yachtshare::find_on_hold();
		$this->template->yachtshares_remind = Model_Yachtshare::find_with_active_reminder();
	}

	public function logged_in_as($types=array())
	{
		// 1. Check that the user has logged in at all
		if($this->user)
		{
			// 2. Check that the user has the right permissions
			$right_type_count = 0;

			foreach($types as $type)
			{
				if($this->user->type == $type)
					$right_type_count++;
			}

			if($right_type_count == 0){
				Session::set_flash('error', 'You do not have permission to access that page!.');
				Response::redirect('session/create');
			}
		}else{
			Session::set_flash('error', 'You must be logged in to access that page.');
			Response::redirect('session/create');
		}
	}

	public function not_logged_in()
	{
		if($this->user)
		{
			//Session::set_flash('error', 'You are already logged in!');
			$url = ($this->user->type == 'admin') ? 'yachtshare' : 'seller';
			Response::redirect($url);			
		}
	}

	protected function handle_post_yachtshares($post_arr, $current_page, $search_terms = array())
	{
		//If the user wants to change columns displayed
		if(isset($post_arr['column'])){
			//Determine which columns are to be displayed depending on user form input
			$columns = array('name', 'make', 'type', 'location_general', 'location_specific', 'length', 'price', 'share_size', 'status', 'introductions', 'last_activity', 'sale_progress', 'created_at', 'seller_name');
			$show_columns = array();

			foreach($columns as $key)
			{
				if(Input::post($key))
					$show_columns[] = $key;
			}

			//Set the session columns as inputted and redirect
			Session::set('columns', $show_columns);
			Response::redirect($current_page);
		}

		//1. User wants to filter results
		if(isset($post_arr['filter']) || count($search_terms) > 0)
		{
			//1. Extract search data
			if(!isset($post_arr['filter']) && count($search_terms) > 0)
			{	
				$search = $search_terms;
			}else{
				$max_share_size = ($post_arr['max_share_size_denomenator'] && $post_arr['max_share_size_numerator']) ? $this->toFloat($post_arr['max_share_size_numerator'].'/'.$post_arr['max_share_size_denomenator']) : '';

				$min_share_size = ($post_arr['min_share_size_denomenator'] && $post_arr['min_share_size_numerator']) ? $this->toFloat($post_arr['min_share_size_numerator'].'/'.$post_arr['min_share_size_denomenator']) : '';

				$search = array(
						'type' 				=> $post_arr['type'],
						'location_general' 	=> $post_arr['location_general'],
						'location_specific' => $post_arr['location_specific'],
						'max_budget' 		=> $post_arr['max_budget'],
						'min_budget' 		=> $post_arr['min_budget'],
						'max_loa' 			=> $post_arr['max_loa'],
						'min_loa' 			=> $post_arr['min_loa'],
						'max_share_size' 	=> $max_share_size,
						'min_share_size' 	=> $min_share_size,
						'max_share_size_numerator' => $post_arr['max_share_size_numerator'],
						'max_share_size_denomenator' =>	$post_arr['max_share_size_denomenator'],
						'min_share_size_numerator' => $post_arr['min_share_size_numerator'],
						'min_share_size_denomenator' =>	$post_arr['min_share_size_denomenator'],
				);
			}

			//2. Filter out mysql columns
			$where = array();
			if($search['type'])
			{
				$where[] = array("type",$search['type']);
			}if($search['location_general']){
				$where[] = array("location_general", $search['location_general']);
			}if($search['location_specific']){
				$where[] = array("location_specific", $search['location_specific']);
			}if($search['max_budget']){
				$where[] = array("price", "<=", $search['max_budget']);
			}if($search['min_budget']){
				$where[] = array("price", ">=", $search['min_budget']);
			}if($search['max_loa']){
				$where[] = array("length", "<=", $search['max_loa']);
			}if($search['min_loa']){
				$where[] = array("length", ">=", $search['min_loa']);
			}

			$this->data['yachtshares'] = (count($where) > 0) ? Model_Yachtshare::find()->where($where)->order_by("name", "ASC")->get() : Model_Yachtshare::find('all',array("order_by" => array("name" => "ASC")));

			$this->data['search_terms'] = $search;

			//3. Now filter out according to share size
			foreach($this->data['yachtshares'] as $id => $yachtshare)
			{
				$max = $this->data['search_terms']['max_share_size'];
				$min = $this->data['search_terms']['min_share_size'];
				$share_size_too_big = (!empty($this->data['search_terms']['max_share_size']) && $yachtshare->share_size > $max);
				$share_size_too_small = (!empty($this->data['search_terms']['min_share_size']) && $yachtshare->share_size < $min);

				if($share_size_too_big || $share_size_too_small)
					unset($this->data['yachtshares'][$id]);
			}

			//4. Filter according to status
			$statuss = array("Available" => "available", "Sale in progress" => "sale_in_progress", "On hold" => "on_hold", "Sold" => "sold", "Deactivated" => "deactivated","Temporarily Saved Form" => "temp");
			
			$stat = array("available","sale_in_progress","on_hold","sold","deactivated","temp");

			//4.1 Find which status's the user has inputted as to be included
			$included_status = array();
			foreach($statuss as $label => $tag)
			{
				if(isset($post_arr[$tag]))
				{
					$included_status[] = $label;
					$this->data['search_terms'][$tag] = true;
				}
			}

			//4.2 Then filter out those which are not of those included status's
			foreach($this->data['yachtshares'] as $id => $yachtshare)
			{
				if(!in_array($yachtshare->status(),$included_status) && count($included_status) > 0)
					unset($this->data['yachtshares'][$id]);
			}
	
		//Or show all yachtshares
		}elseif(isset($post_arr['all'])){
			$this->data['search_terms'] = array(
					'type' => '',
					'location_general' => '',
					'location_specific' => '',
					'max_budget' => '',
					'min_budget' => '',
					'max_loa' => '',
					'min_loa' => '',
					'max_share_size' => '',
					'min_share_size' => '',
					'max_share_size_numerator' => '',
					'max_share_size_denomenator' => '',
					'min_share_size_numerator' => '',
					'min_share_size_denomenator' =>	'',
					'available' => true,
					'on_hold' => true,
					'sale_in_progress' => true,
					'sold' => true,
					'deactivated' => true,
			);

			$this->data['yachtshares'] = Model_Yachtshare::find('all',array("order_by" => array("name" => "ASC")));

		//3. Otherwise use default search
		}else{
			$this->data['search_terms'] = array(
					'type' => '',
					'location_general' => '',
					'location_specific' => '',
					'max_budget' => '',
					'min_budget' => '',
					'max_loa' => '',
					'min_loa' => '',
					'max_share_size' => '',
					'min_share_size' => '',
					'available' => true,
					'sale_in_progress' => true,
					'on_hold' => true,
					'sold' => true,
					'max_share_size_numerator' => '',
					'max_share_size_denomenator' => '',
					'min_share_size_numerator' => '',
					'min_share_size_denomenator' =>	'',
			);

			$this->data['yachtshares'] = Model_Yachtshare::find('all', array("order_by" => array("name" => "ASC")));

			$included_status = array("Available","Sale in progress","On hold", "Sold");
			//Then filter out those which are not of those included status's
			foreach($this->data['yachtshares'] as $id => $yachtshare)
			{
				if(!in_array($yachtshare->status(),$included_status))
					unset($this->data['yachtshares'][$id]);
			}
		}		
	}

	protected function handle_post_buyers($post_arr, $current_page, $search_terms = array())
	{
		//First check if the user has submitted the POST form to change the columns
		if(isset($post_arr['column']))
		{
			//Determine which columns are to be displayed depending on user form input
			$columns = array('name', 'email', 'num_introductions', 'price_range', 'share_size_range', 'length_range', 'type', 'location_general', 'location_specific','sale_progress');
			$show_columns = array();

			foreach($columns as $key)
			{
				if(Input::post($key))
					$show_columns[] = $key;
			}
			//$data['columns'] = $show_columns;
			//Set the session columns as inputted and redirect
			Session::set('columns_buyer', $show_columns);
			Response::redirect($current_page);			
		}

		//If the filter form has been submitted or if the search terms have already been defined
		if(isset($post_arr['filter']) || count($search_terms) > 0)
		{
			//If the form has not been submitted use the pre-defined search terms
			if(!isset($post_arr['filter']) && count($search_terms) > 0)
			{	
				$search = $search_terms;

			//Otherwise use search terms from form via POST
			}else{
				//Work out the share size decimal ($share_size) from the numerator and denominator
				if(!empty($post_arr['share_size_num']) && !empty($post_arr['share_size_den']))
				{
					$share_size = $this->toFloat($post_arr['share_size_num'].'/'.$post_arr['share_size_den']);
				}else{
					$share_size = '';
					$post_arr['share_size_num'] = '';
					$post_arr['share_size_den'] = '';
				}

				$search = array(
						'type' 				=> $post_arr['type'],
						'location_general' 	=> $post_arr['location_general'],
						'location_specific' => $post_arr['location_specific'],
						'price' 			=> $post_arr['price'],
						'length' 			=> $post_arr['length'],
						'share_size' 		=> $share_size,
						'share_size_num' 	=> $post_arr['share_size_num'],
						'share_size_den' 	=> $post_arr['share_size_den'],
				);
			}		

			//Filter the buyers using the search terms
			$this->data['buyers'] = Model_Buyer::find('all');

			foreach($this->data['buyers'] as $id => $buyer)
			{
				$pref = $this->data['buyers'][$id]->preferences;

				//Filter type
				if(!empty($search['type']) and $pref['type'] != $search['type'])
					unset($this->data['buyers'][$id]);

				//Filter location general
				if(!empty($search['location_general']) and strtolower($pref['location_general']) != strtolower($search['location_general']))
					unset($this->data['buyers'][$id]);

				//Filter location specific
				if(!empty($search['location_specific']) and strtolower($pref['location_specific']) != strtolower($search['location_specific']))
					unset($this->data['buyers'][$id]);

				//Filter price
				if(!empty($search['price']) and ($pref['min_budget'] > $search['price'] or $pref['max_budget'] < $search['price']))
					unset($this->data['buyers'][$id]);

				//Filter length
				if(!empty($search['length']) and ($pref['min_loa'] > $search['length'] or $pref['max_loa'] < $search['length']))
					unset($this->data['buyers'][$id]);

				//Filter share size
				$pref_min = $pref['min_share_size'];
				$pref_max = $pref['max_share_size'];
				//!empty($search['share_size']) and $share_size = $this->toFloat($search['share_size']);
				if(!empty($search['share_size']) and ($pref_min > $search['share_size'] or $pref_max < $search['share_size']))
					unset($this->data['buyers'][$id]);
			}

			$this->data['search_terms'] = $search;
		//Otherwise use default filter
		}else{
			$this->data['search_terms'] = array(
					'type' => '',
					'location_general' => '',
					'location_specific' => '',
					'price' => '',
					'length' => '',
					'share_size' => '',
					'share_size_num' => '',
					'share_size_den' => '',
			);

			$this->data['buyers'] = Model_Buyer::find('all');
		}
	}

	protected function toFloat($str)
	{
		$str_arr = explode("/", $str);
		$float = (float) $str_arr[0]/$str_arr[1];
		return round($float,6);
	}

	public function handle_price($price)
	{
		//Remove comma's
		$price = preg_replace('/,/',"",$price);

		//Remove dots and the zeroes after them
		if(preg_match('/\./',$price))
		{
			$price_arr = explode(".",$price);
			return $price_arr[0];
		}else{
			return $price;
		}
	}
}
