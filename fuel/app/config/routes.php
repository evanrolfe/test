<?php
return array(
	'_root_'  => 'yachtshare/home',  // The default route
	'_404_'   => 'welcome/404',    // The main 404 route
	
	'hello(/:name)?' => array('welcome/hello', 'name' => 'hello'),
	//'actionstep/create/:boat_share_id/:buyer_id' => 'actionstep/create',
	'actionstep/create/:boat_share_id/:buyer_id/:actionstep/:from_page' => 'actionstep/create',
	'actionstep/create/:boat_share_id' => 'actionstep/create',
	'actionstep/delete/:id/:from_page' => 'actionstep/delete',
	'image/upload/:boat_id' => 'image/upload',
	'yachtshare/images/:boat_id' => 'image/create',
	'yachtshare/sale/:yachtshare_id' => 'yachtshare/sale',
	'share/filter/:filter' => 'share/index',
	'email/buyer_suggestion/:buyer_id' => 'email/buyer_suggestion',
	'seller/search/:boat_name' => 'seller/search',
	'yachtshare/create/:boat_id' => 'yachtshare/create',
	'email/create/template/:template_id/:buyer_id/:yachtshare_id/:from_page' => 'emailnew/create',
	'emailnew/create/template/:template_id/:buyer_id/:yachtshare_id/:from_page' => 'emailnew/create',
	'mobile' => 'emailnew/mobile',
	'email/create/template/:template_id' => 'email/create',
	'formfieldbuyer/create/:belongs_to' => 'formfieldbuyer/create',
	'formfieldbuyer/order/:belongs_to' => 'formfieldbuyer/order',
	'buyer/find_yachtshares/:buyer_id' => 'yachtshare/find_for_buyer',
	'yachtshare/find_buyers/:yachtshare_id' => 'buyer/find_for_yachtshare',
	'file/delete/:id' => 'file/delete',
	'file/:item/:id' => 'file/index',
	'data/print/:type/:yachtshare_id' => 'data/print',
	'formfieldbuyer/dropdown/:id' => 'formfieldbuyer/dropdown',
	'yachtshare/update/:boat_id' => 'yachtshare/update',
	//'yachtshare/:all'			=> 'yachtshare/index',
	//'buyer/:all'			=> 'buyer/index',
	//'step/create/:yachtshare_id/:buyer_id' => 'actionstep/create',
);
